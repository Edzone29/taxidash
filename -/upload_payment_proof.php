<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include '../php/conn.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

if (!isset($_FILES['paymentProof'])) {
    echo json_encode(['status' => 'error', 'message' => 'Walang napiling file. Mangyaring pumili ng screenshot.']);
    exit;
}

$file = $_FILES['paymentProof'];

// Check upload error code
if ($file['error'] !== UPLOAD_ERR_OK) {
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Masyadong malaki ang file (lampas sa server limit).',
        UPLOAD_ERR_FORM_SIZE  => 'Masyadong malaki ang file.',
        UPLOAD_ERR_PARTIAL    => 'Bahagya lamang na-upload ang file. Pakisubukang muli.',
        UPLOAD_ERR_NO_FILE    => 'Walang file na na-upload.',
        UPLOAD_ERR_NO_TMP_DIR => 'Nawawala ang temporary upload directory sa server.',
        UPLOAD_ERR_CANT_WRITE => 'Pumalya ang pagsusulat ng file sa disk.',
        UPLOAD_ERR_EXTENSION  => 'Hinarang ng server extension ang file upload.'
    ];
    $msg = $errorMessages[$file['error']] ?? ('Hindi ma-upload ang file (Error code: ' . $file['error'] . ')');
    echo json_encode(['status' => 'error', 'message' => $msg]);
    exit;
}

// Validate file type
$allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];
$rawExt = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileExtension = strtolower($rawExt);

// Fallback to MIME type detection if extension is missing
if (empty($fileExtension) && isset($file['type'])) {
    $mime = strtolower($file['type']);
    if (strpos($mime, 'jpeg') !== false || strpos($mime, 'jpg') !== false) $fileExtension = 'jpg';
    elseif (strpos($mime, 'png') !== false) $fileExtension = 'png';
    elseif (strpos($mime, 'webp') !== false) $fileExtension = 'webp';
}

if (!in_array($fileExtension, $allowedExtensions)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Hindi suportado ang format. JPG, JPEG, PNG, o WEBP lamang ang tinatanggap.'
    ]);
    exit;
}

// Determine bookingId
$bookingId = isset($_POST['bookingID']) ? intval($_POST['bookingID']) : 0;
if ($bookingId <= 0 && isset($_SESSION['user_id'])) {
    $userId = intval($_SESSION['user_id']);
    // Check for ride waiting for payment
    $findQuery = "SELECT id FROM temp_ride_bookings WHERE user_id = ? AND status IN (3, 4) ORDER BY id DESC LIMIT 1";
    $stmtFind = $conn->prepare($findQuery);
    $stmtFind->bind_param("i", $userId);
    $stmtFind->execute();
    $resFind = $stmtFind->get_result();
    if ($r = $resFind->fetch_assoc()) {
        $bookingId = intval($r['id']);
    } else {
        // Fallback to latest booking
        $findLatest = "SELECT id FROM temp_ride_bookings WHERE user_id = ? ORDER BY id DESC LIMIT 1";
        $stmtL = $conn->prepare($findLatest);
        $stmtL->bind_param("i", $userId);
        $stmtL->execute();
        $resL = $stmtL->get_result();
        if ($rL = $resL->fetch_assoc()) {
            $bookingId = intval($rL['id']);
        }
        $stmtL->close();
    }
    $stmtFind->close();
}

if ($bookingId <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Hindi matukoy ang aktibong booking ID para sa bayad na ito.'
    ]);
    exit;
}

// Target directory
$uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}

$newFileName = uniqid('payment_', true) . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFileName;

// Move the uploaded file
if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Hindi nai-save ang file sa server. Pakisubukang muli.'
    ]);
    exit;
}

// Update database using prepared statement
$stmt = $conn->prepare("UPDATE temp_ride_bookings SET status = 4, proof = ? WHERE id = ?");
$stmt->bind_param("si", $newFileName, $bookingId);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Matagumpay na naisumite ang payment proof.',
        'bookingId' => $bookingId,
        'filename' => $newFileName
    ]);
} else {
    @unlink($uploadPath);
    echo json_encode([
        'status' => 'error',
        'message' => 'Pumalya ang database update: ' . $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>
