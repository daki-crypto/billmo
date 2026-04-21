<?php
// Profile page for authenticated users
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 900px; margin: 0 auto;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; gap: 20px; flex-wrap: wrap;">
        <div>
            <h1 style="color: #2c3e50; margin-bottom: 6px;">My Profile</h1>
            <p style="color: #666;">View your account details, update your basic information, and manage your password.</p>
        </div>
        <div style="background: white; border-radius: 8px; padding: 14px 18px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); min-width: 220px;">
            <div style="font-size: 12px; color: #666; text-transform: uppercase; margin-bottom: 6px;">Account Snapshot</div>
            <div style="font-size: 16px; font-weight: 700; color: #2c3e50;"><?= esc($user['name']) ?></div>
            <div style="font-size: 14px; color: #666;"><?= esc($user['email']) ?></div>
            <div style="margin-top: 8px;">
                <span class="badge" style="background-color: <?= $user['role'] === 'admin' ? '#dc3545' : '#28a745' ?>; color: white; padding: 4px 10px; border-radius: 999px;">
                    <?= ucfirst($user['role']) ?>
                </span>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('temporary_password')): ?>
        <div style="background: #fff3cd; color: #856404; padding: 16px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid #ffc107;">
            <strong>Temporary Password:</strong> <?= esc(session()->getFlashdata('temporary_password')) ?>
            <div style="margin-top: 6px; font-size: 13px;">Store this password now, then use Change Password to set one you prefer.</div>
        </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; align-items: start;">
        <div class="form-container" style="max-width: none;">
            <h2 style="color: #2c3e50; margin-bottom: 16px;">Basic Information</h2>

            <?php if (session()->has('profile_errors')): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                    <strong>Please fix the following profile errors:</strong>
                    <ul style="margin-top: 10px; margin-left: 20px;">
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

        <div style="display: grid; gap: 20px;">
            <div class="form-container" style="max-width: none;">
                <h2 style="color: #2c3e50; margin-bottom: 16px;">Change Password</h2>

                <?php if (session()->has('password_errors')): ?>
                    <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #f5c6cb;">
                        <strong>Please fix the following password errors:</strong>
                        <ul style="margin-top: 10px; margin-left: 20px;">
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
                        <small style="display: block; margin-top: 6px; color: #666;">Use at least 8 characters with uppercase, lowercase, number, and special character.</small>
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

            <div class="form-container" style="max-width: none;">
                <h2 style="color: #2c3e50; margin-bottom: 12px;">Reset Password</h2>
                <p style="color: #666; line-height: 1.6; margin-bottom: 16px;">Resetting generates a one-time temporary password for your account. Use it to log in, then change your password immediately.</p>

                <form method="POST" action="<?= base_url('profile/reset-password') ?>" onsubmit="return confirm('Generate a temporary password for this account?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>