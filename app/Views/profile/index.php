<?php
// Profile page for authenticated users
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-lg">
    <div class="profile-top">
        <div>
            <h1 class="page-title">My Profile</h1>
            <p class="page-subtitle">View your account details, update your basic information, and manage your password.</p>
        </div>
        <div class="snapshot-card">
            <div class="snapshot-label">Account Snapshot</div>
            <div class="snapshot-name"><?= esc($user['name']) ?></div>
            <div class="snapshot-email"><?= esc($user['email']) ?></div>
            <div class="snapshot-role-wrap">
                <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-normal' ?>">
                    <?= ucfirst($user['role']) ?>
                </span>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('temporary_password')): ?>
        <div class="temp-password-box">
            <strong>Temporary Password:</strong> <?= esc(session()->getFlashdata('temporary_password')) ?>
            <div class="temp-password-note">Store this password now, then use Change Password to set one you prefer.</div>
        </div>
    <?php endif; ?>

    <div class="profile-grid">
        <div class="form-container full-width-form">
            <h2 class="section-title">Basic Information</h2>

            <?php if (session()->has('profile_errors')): ?>
                <div class="error-box">
                    <strong>Please fix the following profile errors:</strong>
                    <ul class="error-list">
                        <?php foreach (session('profile_errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('profile/update') ?>">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?= esc(old('name', $user['name'])) ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= esc(old('email', $user['email'])) ?>" required>
                </div>

                <div class="form-group">
                    <label>User ID</label>
                    <input type="text" value="<?= esc(format_user_id($user['id'])) ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Role</label>
                    <input type="text" value="<?= esc(ucfirst($user['role'])) ?>" readonly>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Save Profile</button>
                </div>
            </form>
        </div>

        <div class="profile-side-stack">
            <div class="form-container full-width-form">
                <h2 class="section-title">Change Password</h2>

                <?php if (session()->has('password_errors')): ?>
                    <div class="error-box">
                        <strong>Please fix the following password errors:</strong>
                        <ul class="error-list">
                            <?php foreach (session('password_errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?= base_url('profile/change-password') ?>" autocomplete="off">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required autocomplete="off">
                        <small class="form-note">Use at least 8 characters with uppercase, lowercase, number, and special character.</small>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required autocomplete="off">
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-success">Change Password</button>
                    </div>
                </form>
            </div>

            <div class="form-container full-width-form">
                <h2 class="section-title-small-gap">Reset Password</h2>
                <p class="help-text">Resetting generates a one-time temporary password for your account. Use it to log in, then change your password immediately.</p>

                <form method="POST" action="<?= base_url('profile/reset-password') ?>" onsubmit="return confirm('Generate a temporary password for this account?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>