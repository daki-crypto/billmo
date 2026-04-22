<?php
// Create client form (updated)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-sm">
    <h1 class="page-title">Create New Client</h1>

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
        <form method="POST" action="<?= base_url('clients/store') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Client Name <span class="required-mark">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter client name" required>
            </div>

            <div class="form-group">
                <label for="address">Address <span class="required-mark">*</span></label>
                <textarea id="address" name="address" placeholder="Enter client address" required><?= old('address') ?></textarea>
            </div>

            <div class="form-group">
                <label for="meter_number">Meter Number <span class="required-mark">*</span></label>
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
