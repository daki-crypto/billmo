<?php
// Edit user view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-sm">
    <h1 class="page-title">Edit User: <?= $user['name'] ?></h1>

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
        <form method="POST" action="<?= base_url('users/' . $user['id'] . '/update') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="name">Full Name <span class="required-mark">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name', $user['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span class="required-mark">*</span></label>
                <input type="email" id="email" name="email" value="<?= old('email', $user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" placeholder="Leave blank or use 8+ chars with Aa1!" autocomplete="off">
                <small class="form-note">If you set a new password, it must include uppercase, lowercase, number, and special character.</small>
            </div>

            <div class="form-group">
                <label for="role">Role <span class="required-mark">*</span></label>
                <select id="role" name="role" required>
                    <option value="admin" <?= old('role', $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="normal" <?= old('role', $user['role']) === 'normal' ? 'selected' : '' ?>>Normal User</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="<?= base_url('users/' . $user['id']) ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
