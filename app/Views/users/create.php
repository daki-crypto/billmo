<?php
// Create user view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 0 auto;">
    <h1 style="color: #2c3e50; margin-bottom: 20px;">Create New User</h1>

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
        <form method="POST" action="<?= base_url('users/store') ?>">
            <!-- Autofill prevention: hidden fake fields -->
            <input type="text" name="fakeusernameremembered" style="display:none" autocomplete="off">
            <input type="password" name="fakepasswordremembered" style="display:none" autocomplete="off">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Full Name <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter user name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter email" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="password">Password <span style="color: red;">*</span></label>
                <input type="password" id="password" name="password" placeholder="Use 8+ chars with Aa1!" required autocomplete="off">
                <small style="display: block; margin-top: 6px; color: #666;">Use uppercase, lowercase, number, and special character.</small>
            </div>

            <div class="form-group">
                <label for="role">Role <span style="color: red;">*</span></label>
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
