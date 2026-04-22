<?php
// Show bill view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-md">
    <div class="spacer-bottom-20">
        <a href="<?= base_url('bills') ?>" class="back-link">← Back to Bills</a>
    </div>

    <div class="info-panel">
        <h1 class="heading-spaced">Bill Details</h1>

        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">Bill ID</label>
                <p class="field-value-lg"><?= format_six_digit_id($bill['id']) ?></p>
            </div>
            <div>
                <label class="field-label-muted">Created At</label>
                <p class="field-value-lg"><?= date('M d, Y H:i', strtotime($bill['created_at'])) ?></p>
            </div>
        </div>

        <hr class="hr-separator">

        <h3 class="subheading">Client Information</h3>
        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">Client Name</label>
                <p class="field-value"><?= $bill['client_name'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Created By</label>
                <p class="field-value"><?= $bill['user_name'] ?></p>
            </div>
        </div>

        <hr class="hr-separator">

        <h3 class="subheading">Billing Details</h3>
        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">Billing Month</label>
                <p class="field-value"><?= date('M Y', strtotime($bill['billing_month'])) ?></p>
            </div>
            <div>
                <label class="field-label-muted">Units Consumed</label>
                <p class="field-value"><?= number_format($bill['units_consumed'], 2) ?> kWh</p>
            </div>
            <div>
                <label class="field-label-muted">Rate Per Unit</label>
                <p class="field-value">₱<?= number_format($bill['rate_per_unit'], 2) ?></p>
            </div>
            <div>
                <label class="field-label-muted">Total Amount</label>
                <p class="field-value-xl">₱<?= number_format($bill['total_amount'], 2) ?></p>
            </div>
        </div>

        <hr class="hr-separator">

        <div>
            <a href="<?= base_url('bills') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
