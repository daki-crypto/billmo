<?php
// Show user view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-md">
    <div class="spacer-bottom-20">
        <a href="<?= base_url('users') ?>" class="back-link">← Back to Users</a>
    </div>

    <div class="info-panel">
        <h1 class="heading-spaced"><?= $user['name'] ?></h1>

        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">User ID</label>
                <p class="field-value"><?= format_user_id($user['id']) ?></p>
            </div>
            <div>
                <label class="field-label-muted">Email</label>
                <p class="field-value"><?= $user['email'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Role</label>
                <p>
                    <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-normal' ?>">
                        <?= ucfirst($user['role']) ?>
                    </span>
                </p>
            </div>
            <div>
                <label class="field-label-muted">Created At</label>
                <p class="field-value"><?= date('M d, Y H:i', strtotime($user['created_at'])) ?></p>
            </div>
        </div>

        <hr class="hr-separator">

        <div>
            <a href="<?= base_url('users/' . $user['id'] . '/edit') ?>" class="btn btn-primary">Edit User</a>
            <?php if ($user['id'] !== session('user_id')): ?>
                <form method="POST" action="<?= base_url('users/' . $user['id'] . '/delete') ?>" class="inline-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete User</button>
                </form>
            <?php endif; ?>
            <a href="<?= base_url('users') ?>" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
