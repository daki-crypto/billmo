<?php
// Users list view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <div class="page-header-row">
        <h1 class="page-title-no-margin">User Management</h1>
        <a href="<?= base_url('users/create') ?>" class="btn btn-success">+ Create New User</a>
    </div>

    <?php if (!empty($users)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= format_user_id($user['id']) ?></td>
                        <td class="field-value"><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <span class="badge <?= $user['role'] === 'admin' ? 'badge-admin' : 'badge-normal' ?>">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('users/' . $user['id']) ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="<?= base_url('users/' . $user['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            <?php if ($user['id'] !== session('user_id')): ?>
                                <form method="POST" action="<?= base_url('users/' . $user['id'] . '/delete') ?>" class="inline-form">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state-card">
            <p class="empty-state-text">No users found.</p>
            <a href="<?= base_url('users/create') ?>" class="btn btn-success top-gap-15">Create First User</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
