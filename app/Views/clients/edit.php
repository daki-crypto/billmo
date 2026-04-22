<?php
// Edit client view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-sm">
    <h1 class="page-title">Edit Client: <?= $client['name'] ?></h1>

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
        <form method="POST" action="<?= base_url('clients/' . $client['id'] . '/update') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Client Name <span class="required-mark">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name', $client['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address <span class="required-mark">*</span></label>
                <textarea id="address" name="address" required><?= old('address', $client['address']) ?></textarea>
            </div>

            <div class="form-group">
                <label for="meter_number">Meter Number <span class="required-mark">*</span></label>
                <input type="text" id="meter_number" name="meter_number" value="<?= old('meter_number', $client['meter_number']) ?>" required>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Update Client</button>
                <a href="<?= base_url('clients/' . $client['id']) ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
