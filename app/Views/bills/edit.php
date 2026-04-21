<?php
// Edit bill view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 0 auto;">
    <h1 style="color: #2c3e50; margin-bottom: 20px;">Edit Bill #<?= $bill['id'] ?></h1>

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
        <form method="POST" action="<?= base_url('bills/' . $bill['id'] . '/update') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="client_id">Client <span style="color: red;">*</span></label>
                <select id="client_id" name="client_id" required>
                    <option value="">-- Select Client --</option>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" <?= old('client_id', $bill['client_id']) == $client['id'] ? 'selected' : '' ?>>
                            <?= $client['name'] ?> (<?= $client['meter_number'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">Created By <span style="color: red;">*</span></label>
                <select id="user_id" name="user_id" required>
                    <option value="">-- Select User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= old('user_id', $bill['user_id']) == $user['id'] ? 'selected' : '' ?>>
                            <?= $user['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="billing_month">Billing Month <span style="color: red;">*</span></label>
                <input type="date" id="billing_month" name="billing_month" value="<?= old('billing_month', $bill['billing_month']) ?>" required>
            </div>

            <div class="form-group">
                <label for="units_consumed">Units Consumed <span style="color: red;">*</span></label>
                <input type="number" id="units_consumed" name="units_consumed" step="0.01" value="<?= old('units_consumed', $bill['units_consumed']) ?>" required>
            </div>

            <div class="form-group">
                <label for="rate_per_unit">Rate Per Unit (₱) <span style="color: red;">*</span></label>
                <input type="number" id="rate_per_unit" name="rate_per_unit" step="0.01" value="<?= old('rate_per_unit', $bill['rate_per_unit']) ?>" required>
            </div>

            <div class="form-group">
                <label for="total_amount">Total Amount (₱) <span style="color: red;">*</span></label>
                <input type="number" id="total_amount" name="total_amount" step="0.01" value="<?= old('total_amount', $bill['total_amount']) ?>" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Update Bill</button>
                <a href="<?= base_url('bills/' . $bill['id']) ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
