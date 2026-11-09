<?php
/**
 * TaxiDash Booking Progress Stepper
 * Pass $currentStep = 1..7 before including this partial
 */
$currentStep = $currentStep ?? 1;

$steps = [
    1 => ['label' => 'Book Ride', 'icon' => 'fa-map-marker-alt'],
    2 => ['label' => 'Review',    'icon' => 'fa-receipt'],
    3 => ['label' => 'Driver',    'icon' => 'fa-search-location'],
    4 => ['label' => 'Payment',   'icon' => 'fa-wallet'],
    5 => ['label' => 'Pickup',    'icon' => 'fa-taxi'],
    6 => ['label' => 'Trip',      'icon' => 'fa-route'],
    7 => ['label' => 'Done',      'icon' => 'fa-star']
];
?>
<style>
.taxidash-stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    max-width: 680px;
    margin: 0 auto 24px;
    padding: 12px 16px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    border: 1px solid #eef2f6;
}
.taxidash-stepper::before {
    content: '';
    position: absolute;
    top: 32px;
    left: 45px;
    right: 45px;
    height: 3px;
    background: #e2e8f0;
    z-index: 1;
}
.taxidash-stepper-progress {
    position: absolute;
    top: 32px;
    left: 45px;
    height: 3px;
    background: linear-gradient(90deg, #1e3c72, #3bafda);
    z-index: 1;
    transition: width 0.4s ease;
}
.taxidash-step {
    position: relative;
    z-index: 2;
    text-align: center;
    flex: 1;
}
.taxidash-step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin: 0 auto 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.95rem;
    font-weight: 700;
    background: #f1f5f9;
    color: #94a3b8;
    border: 3px solid #ffffff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}
.taxidash-step.active .taxidash-step-circle {
    background: linear-gradient(135deg, #1e3c72, #3bafda);
    color: #ffffff;
    transform: scale(1.15);
    box-shadow: 0 6px 16px rgba(59,175,218,0.45);
}
.taxidash-step.completed .taxidash-step-circle {
    background: #10b981;
    color: #ffffff;
}
.taxidash-step-label {
    font-size: 0.72rem;
    font-weight: 600;
    color: #94a3b8;
    white-space: nowrap;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.taxidash-step.active .taxidash-step-label {
    color: #1e3c72;
    font-weight: 700;
}
.taxidash-step.completed .taxidash-step-label {
    color: #10b981;
}
@media (max-width: 576px) {
    .taxidash-step-label { display: none; }
    .taxidash-step-circle { width: 32px; height: 32px; font-size: 0.8rem; }
    .taxidash-stepper::before, .taxidash-stepper-progress { top: 28px; left: 24px; right: 24px; }
}
</style>

<div class="taxidash-stepper">
    <?php
    $progressPercent = (($currentStep - 1) / (count($steps) - 1)) * 100;
    ?>
    <div class="taxidash-stepper-progress" style="width: calc(<?=min(100, max(0, $progressPercent))?>% * 0.86);"></div>

    <?php foreach ($steps as $num => $s): 
        $class = '';
        if ($num < $currentStep) $class = 'completed';
        elseif ($num === $currentStep) $class = 'active';
    ?>
        <div class="taxidash-step <?=$class?>">
            <div class="taxidash-step-circle">
                <?php if ($num < $currentStep): ?>
                    <i class="fas fa-check"></i>
                <?php else: ?>
                    <i class="fas <?=$s['icon']?>"></i>
                <?php endif; ?>
            </div>
            <div class="taxidash-step-label"><?=$s['label']?></div>
        </div>
    <?php endforeach; ?>
</div>
