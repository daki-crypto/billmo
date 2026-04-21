<?php
// Show user view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('users') ?>" style="color: #007bff; text-decoration: none;">← Back to Users</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h1 style="color: #2c3e50; margin-bottom: 30px;"><?= $user['name'] ?></h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">User ID</label>
                <p style="font-size: 16px; font-weight: bold;"><?= format_user_id($user['id']) ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Email</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $user['email'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Role</label>
                <p>
                    <span class="badge" style="background-color: <?= $user['role'] === 'admin' ? '#dc3545' : '#28a745' ?>; color: white; padding: 6px 12px; border-radius: 4px; display: inline-block; font-weight: bold;">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Created At</label>
                <p style="font-size: 16px; font-weight: bold;"><?= date('M d, Y H:i', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <hr style="margin: 20px 0; border: none; border-top: 1px solid #ddd;">

        <div>
            <a href="<?= base_url('users/' . $user['id'] . '/edit') ?>" class="btn btn-primary">Edit User</a>
            <?php if ($user['id'] !== session('user_id')): ?>
                <form method="POST" action="<?= base_url('users/' . $user['id'] . '/delete') ?>" style="display:inline;"
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete User</button>
                </form>
            <?php endif; ?>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
