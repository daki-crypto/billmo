<?php
// Audit logs view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <h1 style="color: #2c3e50; margin-bottom: 20px;">
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
                            <span class="badge badge-info" style="display: inline-block; padding: 6px 12px; border-radius: 4px; background-color: #17a2b8; color: white; font-size: 12px;">
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
        <div style="background: white; padding: 40px; text-align: center; border-radius: 4px;">
            <p style="color: #666; font-size: 16px;">No audit logs found.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
