<?php
// Bill summary view (Normal user)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 900px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('billing/history') ?>" style="color: #007bff; text-decoration: none;">← Back to My Billing History</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="color: #2c3e50; margin-bottom: 10px;">Bill Summary</h1>
        <p style="color: #666; margin-bottom: 25px;">Detailed summary of your computed electric bill.</p>

        <div class="stats-grid" style="margin-bottom: 25px;">
            <div class="stat-card">
                <h3>Bill ID</h3>
                <div class="stat-number" style="font-size: 24px;"><?= format_six_digit_id($bill['id']) ?></div>
            </div>
            <div class="stat-card">
                <h3>Billing Month</h3>
                <div class="stat-number" style="font-size: 24px;"><?= date('M Y', strtotime($bill['billing_month'])) ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Amount</h3>
                <div class="stat-number">₱<?= number_format($bill['total_amount'], 2) ?></div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Client Name</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $bill['client_name'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Meter Number</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $bill['meter_number'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Client Address</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $bill['client_address'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Created At</label>
                <p style="font-size: 16px; font-weight: bold;"><?= date('M d, Y H:i', strtotime($bill['created_at'])) ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div class="stat-card">
                <h3>Units Consumed</h3>
                <div class="stat-number" style="font-size: 26px;"><?= number_format($bill['units_consumed'], 2) ?></div>
                <p style="color: #666; font-size: 12px; margin-top: 5px;">kWh</p>
            </div>
            <div class="stat-card">
                <h3>Rate Per Unit</h3>
                <div class="stat-number" style="font-size: 26px;">₱<?= number_format($bill['rate_per_unit'], 2) ?></div>
            </div>
            <div class="stat-card">
                <h3>Computation</h3>
                <div style="font-size: 20px; font-weight: bold; color: #2c3e50;">
                    <?= number_format($bill['units_consumed'], 2) ?> × ₱<?= number_format($bill['rate_per_unit'], 2) ?>
                </div>
            </div>
        </div>

        <div style="background: #f0f8ff; padding: 20px; border-radius: 4px; border-left: 4px solid #007bff;">
            <label style="color: #0c5460; font-size: 12px; text-transform: uppercase; display: block; margin-bottom: 8px;">Final Bill Total</label>
            <p style="font-size: 30px; font-weight: bold; color: #007bff;">₱<?= number_format($bill['total_amount'], 2) ?></p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>