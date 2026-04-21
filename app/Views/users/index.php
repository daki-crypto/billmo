<?php
// Users list view (Admin only)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="color: #2c3e50;">User Management</h1>
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
                        <td style="font-weight: 600;"><?= $user['name'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td>
                            <span class="badge" style="background-color: <?= $user['role'] === 'admin' ? '#dc3545' : '#28a745' ?>; color: white; padding: 4px 8px; border-radius: 4px; display: inline-block;">
                                <?= ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('users/' . $user['id']) ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="<?= base_url('users/' . $user['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            <?php if ($user['id'] !== session('user_id')): ?>
                                <form method="POST" action="<?= base_url('users/' . $user['id'] . '/delete') ?>" style="display:inline;">
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
        <div style="background: white; padding: 40px; text-align: center; border-radius: 4px;">
            <p style="color: #666; font-size: 16px;">No users found.</p>
            <a href="<?= base_url('users/create') ?>" class="btn btn-success" style="margin-top: 15px;">Create First User</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
