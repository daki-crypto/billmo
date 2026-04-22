<?php
// Compute bill view (Normal user)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-sm">
    <h1 class="page-title">Compute Electric Bill</h1>

    <?php if (session()->has('errors')): ?>
        <div class="error-box">
            <strong>Please fix the following errors:</strong>
            <ul class="error-list">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <form method="POST" action="<?= base_url('billing/store') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="client_name">Client Name <span class="required-mark">*</span></label>
                <input type="text" id="client_name" name="client_name" value="<?= old('client_name') ?>" placeholder="Enter client name" required>
            </div>

            <div class="form-group form-group-meter">
                <label for="meter_number">Meter Number <span class="required-mark">*</span></label>
                <input type="text" id="meter_number" name="meter_number" value="<?= old('meter_number') ?>" placeholder="e.g. MTR-0001" required>
            </div>

            <div class="form-group">
                <label for="client_address">Client Address <span class="required-mark">*</span></label>
                <input type="text" id="client_address" name="client_address" value="<?= old('client_address') ?>" placeholder="Enter client address" required>
            </div>

            <div class="form-group">
                <label for="billing_month">Billing Month <span class="required-mark">*</span></label>
                <input type="date" id="billing_month" name="billing_month" value="<?= old('billing_month') ?>" required>
            </div>

            <div class="form-group">
                <label for="units_consumed">Units Consumed (kWh) <span class="required-mark">*</span></label>
                <input type="number" id="units_consumed" name="units_consumed" step="0.01" value="<?= old('units_consumed') ?>" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="rate_per_unit">Applied Rate Per Unit (₱)</label>
                <input type="number" id="rate_per_unit" name="rate_per_unit" step="0.01" value="0.00" readonly>
            </div>

            <div class="info-block info-block-rates">
                <label class="info-label">Tiered Billing Rates</label>
                <div class="rates-grid">
                    <strong>Consumption Range</strong>
                    <strong>Rate</strong>
                    <span>1 - 200 kWh</span>
                    <span>₱10.00</span>
                    <span>201 - 500 kWh</span>
                    <span>₱13.00</span>
                    <span>501 kWh and above</span>
                    <span>₱15.00</span>
                </div>
            </div>

            <div class="info-block info-block-total">
                <label class="info-label info-label-accent">Calculated Total Amount</label>
                <p class="total-amount-text">₱<span id="totalAmount">0.00</span></p>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Compute & Save Bill</button>
            </div>
        </form>
    </div>
</div>

<script>
    const units = document.getElementById('units_consumed');
    const rate = document.getElementById('rate_per_unit');
    const total = document.getElementById('totalAmount');

    function resolveTierRate(unitValue) {
        if (unitValue <= 200) {
            return 10;
        }

        if (unitValue <= 500) {
            return 13;
        }

        return 15;
    }
    
    function calculateTotal() {
        const u = parseFloat(units.value) || 0;
        const r = u > 0 ? resolveTierRate(u) : 0;
        rate.value = r.toFixed(2);
        const t = (u * r).toFixed(2);
        total.textContent = t;
    }
    
    units.addEventListener('input', calculateTotal);
    calculateTotal();
</script>

<?= $this->endSection() ?>
