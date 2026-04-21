<?php
// Show bill view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('bills') ?>" style="color: #007bff; text-decoration: none;">← Back to Bills</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="color: #2c3e50; margin-bottom: 30px;">Bill Details</h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Bill ID</label>
                <p style="font-size: 18px; font-weight: bold;"><?= format_six_digit_id($bill['id']) ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Created At</label>
                <p style="font-size: 18px; font-weight: bold;"><?= date('M d, Y H:i', strtotime($bill['created_at'])) ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <h3 style="color: #2c3e50; margin-bottom: 15px;">Client Information</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Client Name</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $bill['client_name'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Created By</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $bill['user_name'] ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <h3 style="color: #2c3e50; margin-bottom: 15px;">Billing Details</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Billing Month</label>
                <p style="font-size: 16px; font-weight: bold;"><?= date('M Y', strtotime($bill['billing_month'])) ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Units Consumed</label>
                <p style="font-size: 16px; font-weight: bold;"><?= number_format($bill['units_consumed'], 2) ?> kWh</p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Rate Per Unit</label>
                <p style="font-size: 16px; font-weight: bold;">₱<?= number_format($bill['rate_per_unit'], 2) ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Total Amount</label>
                <p style="font-size: 20px; font-weight: bold; color: #007bff;">₱<?= number_format($bill['total_amount'], 2) ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <div>
            <a href="<?= base_url('bills') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
