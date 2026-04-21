<?php
// Compute bill view (Normal user)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 0 auto;">
    <h1 style="color: #2c3e50; margin-bottom: 20px;">Compute Electric Bill</h1>

    <?php if (session()->has('errors')): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top: 10px; margin-left: 20px;">
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
                <label for="client_id">Select Client <span style="color: red;">*</span></label>
                <select id="client_id" name="client_id" required>
                    <option value="">-- Select Client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" <?= old('client_id') == $client['id'] ? 'selected' : '' ?>>
                            <?= $client['name'] ?> (<?= $client['meter_number'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="billing_month">Billing Month <span style="color: red;">*</span></label>
                <input type="date" id="billing_month" name="billing_month" value="<?= old('billing_month') ?>" required>
            </div>

            <div class="form-group">
                <label for="units_consumed">Units Consumed (kWh) <span style="color: red;">*</span></label>
                <input type="number" id="units_consumed" name="units_consumed" step="0.01" value="<?= old('units_consumed') ?>" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label for="rate_per_unit">Applied Rate Per Unit (₱)</label>
                <input type="number" id="rate_per_unit" name="rate_per_unit" step="0.01" value="0.00" readonly>
            </div>

            <div style="background: #f8f9fa; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #17a2b8;">
                <label style="color: #2c3e50; font-size: 12px; text-transform: uppercase; display: block; margin-bottom: 8px;">Tiered Billing Rates</label>
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 8px; color: #495057; font-size: 14px;">
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

            <div style="background: #f0f8ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #007bff;">
                <label style="color: #0c5460; font-size: 12px; text-transform: uppercase; display: block; margin-bottom: 8px;">Calculated Total Amount</label>
                <p style="font-size: 24px; font-weight: bold; color: #007bff;">₱<span id="totalAmount">0.00</span></p>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Compute & Save Bill</button>
                <a href="<?= base_url('billing/history') ?>" class="btn btn-secondary">View History</a>
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
