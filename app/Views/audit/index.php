<?php
// Audit logs view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <h1 class="page-title">
        <?= $userRole === 'admin' ? 'System Audit Logs' : 'My Action Logs' ?>
    </h1>

    <?php if (!empty($logs)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <?php if ($userRole === 'admin'): ?>
                        <th>User</th>
                    <?php endif; ?>
                    <th>Action</th>
                    <th>Description</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <?php if ($userRole === 'admin'): ?>
                            <td><?= format_user_id($log['user_id']) ?></td>
                        <?php endif; ?>
                        <td>
                            <span class="badge badge-action">
                                <?= $log['action'] ?>
                            </span>
                        </td>
                        <td><?= $log['description'] ?></td>
                        <td><?= date('M d, Y H:i:s', strtotime($log['created_at'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state-card">
            <p class="empty-state-text">No audit logs found.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
