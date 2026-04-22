<?php
// Create user view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-sm">
    <h1 class="page-title">Create New User</h1>

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
        <form method="POST" action="<?= base_url('users/store') ?>">
            <!-- Autofill prevention: hidden fake fields -->
            <input type="text" name="fakeusernameremembered" class="hidden-field" autocomplete="off">
            <input type="password" name="fakepasswordremembered" class="hidden-field" autocomplete="off">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Full Name <span class="required-mark">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter user name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span class="required-mark">*</span></label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter email" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required-mark">*</span></label>
                <input type="password" id="password" name="password" placeholder="Use 8+ chars with Aa1!" required autocomplete="off">
                <small class="form-note">Use uppercase, lowercase, number, and special character.</small>
            </div>

            <div class="form-group">
                <label for="role">Role <span class="required-mark">*</span></label>
                <select id="role" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="normal" <?= old('role') === 'normal' ? 'selected' : '' ?>>Normal User</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-success">Create User</button>
                <a href="<?= base_url('users') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
