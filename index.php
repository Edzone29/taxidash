<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaxiDash</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body, html {
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3bafda 100%);
      overflow: hidden;
    }
    .splash-screen {
      text-align: center;
      animation: popIn 0.5s cubic-bezier(0.34,1.56,0.64,1) both;
    }
    @keyframes popIn {
      from { transform: scale(0.7); opacity: 0; }
      to   { transform: scale(1);   opacity: 1; }
    }
    .logo-wrap {
      width: 160px; height: 160px;
      border-radius: 32px;
      overflow: hidden;
      margin: 0 auto 20px;
      box-shadow: 0 12px 40px rgba(0,0,0,0.35);
      border: 4px solid rgba(255,255,255,0.3);
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% { box-shadow: 0 12px 40px rgba(0,0,0,0.35), 0 0 0 0 rgba(255,255,255,0.4); }
      50%       { box-shadow: 0 12px 40px rgba(0,0,0,0.35), 0 0 0 12px rgba(255,255,255,0); }
    }
    .logo-wrap img { width: 100%; height: 100%; object-fit: cover; }
    h1 {
      color: #fff;
      font-size: 2rem;
      font-weight: 700;
      letter-spacing: 2px;
      margin-bottom: 6px;
      text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    .tagline {
      color: rgba(255,255,255,0.75);
      font-size: 0.95rem;
      margin-bottom: 30px;
      letter-spacing: 1px;
    }
    .spinner-custom {
      width: 48px; height: 48px;
      border: 5px solid rgba(255,255,255,0.2);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
      margin: 0 auto;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .loading-text {
      color: rgba(255,255,255,0.65);
      font-size: 0.82rem;
      margin-top: 14px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
    }
    .progress-bar-wrap {
      width: 160px;
      height: 3px;
      background: rgba(255,255,255,0.2);
      border-radius: 10px;
      margin: 14px auto 0;
      overflow: hidden;
    }
    .progress-fill {
      height: 100%;
      width: 0%;
      background: #fff;
      border-radius: 10px;
      animation: progressAnim 1.2s ease forwards;
    }
    @keyframes progressAnim { to { width: 100%; } }
  </style>
</head>
<body>
<div class="splash-screen">
  <div class="logo-wrap">
    <img src="taxi.jpg" alt="TaxiDash Logo">
  </div>
  <h1>TAXIDASH</h1>
  <p class="tagline">Your Ride, Your Way</p>
  <div class="spinner-custom"></div>
  <div class="progress-bar-wrap"><div class="progress-fill"></div></div>
  <p class="loading-text">Loading...</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
  setTimeout(function() {
    document.querySelector('.splash-screen').style.transition = 'opacity 0.4s ease';
    document.querySelector('.splash-screen').style.opacity = '0';
    setTimeout(() => { window.location.href = "login.php"; }, 400);
  }, 1800);
</script>
</body>
</html>
