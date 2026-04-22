<?php
// Bill summary view (Normal user)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-lg">
    <div class="spacer-bottom-20">
        <a href="<?= base_url('billing/history') ?>" class="back-link">← Back to My Billing History</a>
    </div>

    <div class="info-panel">
        <h1 class="page-title">Bill Summary</h1>
        <p class="page-subtitle spacer-bottom-20">Detailed summary of your computed electric bill.</p>

        <div class="stats-grid spacer-bottom-20">
            <div class="stat-card">
                <h3>Bill ID</h3>
                <div class="stat-number field-value-lg"><?= format_six_digit_id($bill['id']) ?></div>
            </div>
            <div class="stat-card">
                <h3>Billing Month</h3>
                <div class="stat-number field-value-lg"><?= date('M Y', strtotime($bill['billing_month'])) ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Amount</h3>
                <div class="stat-number">₱<?= number_format($bill['total_amount'], 2) ?></div>
            </div>
        </div>

        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">Client Name</label>
                <p class="field-value"><?= $bill['client_name'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Meter Number</label>
                <p class="field-value"><?= $bill['meter_number'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Client Address</label>
                <p class="field-value"><?= $bill['client_address'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Created At</label>
                <p class="field-value"><?= date('M d, Y H:i', strtotime($bill['created_at'])) ?></p>
            </div>
        </div>

        <hr class="hr-separator">

        <div class="field-grid-three">
            <div class="stat-card">
                <h3>Units Consumed</h3>
                <div class="stat-number field-value-lg"><?= number_format($bill['units_consumed'], 2) ?></div>
                <p class="field-label-muted">kWh</p>
            </div>
            <div class="stat-card">
                <h3>Rate Per Unit</h3>
                <div class="stat-number field-value-lg">₱<?= number_format($bill['rate_per_unit'], 2) ?></div>
            </div>
            <div class="stat-card">
                <h3>Computation</h3>
                <div class="field-value-xl">
                    <?= number_format($bill['units_consumed'], 2) ?> × ₱<?= number_format($bill['rate_per_unit'], 2) ?>
                </div>
            </div>
        </div>

        <div class="info-block info-block-total">
            <label class="info-label info-label-accent">Final Bill Total</label>
            <p class="total-amount-text">₱<?= number_format($bill['total_amount'], 2) ?></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>