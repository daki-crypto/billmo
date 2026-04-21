<?php
// Create client form (updated)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 0 auto;">
    <h1 style="color: #2c3e50; margin-bottom: 20px;">Create New Client</h1>

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
        <form method="POST" action="<?= base_url('clients/store') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Client Name <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter client name" required>
            </div>

            <div class="form-group">
                <label for="address">Address <span style="color: red;">*</span></label>
                <textarea id="address" name="address" placeholder="Enter client address" required><?= old('address') ?></textarea>
            </div>

            <div class="form-group">
                <label for="meter_number">Meter Number <span style="color: red;">*</span></label>
                <input type="text" id="meter_number" name="meter_number" value="<?= old('meter_number') ?>" placeholder="Enter unique meter number" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Create Client</button>
                <a href="<?= base_url('clients') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
