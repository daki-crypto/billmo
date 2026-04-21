<?php
// Clients index view (updated)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="color: #2c3e50;">Clients Management</h1>
        <a href="<?= base_url('clients/create') ?>" class="btn btn-success">+ Create New Client</a>
    </div>

    <?php if (!empty($clients)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Meter Number</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= format_six_digit_id($client['id']) ?></td>
                        <td style="font-weight: 600;"><?= $client['name'] ?></td>
                        <td><span class="badge badge-info"><?= $client['meter_number'] ?></span></td>
                        <td><?= strlen($client['address']) > 40 ? substr($client['address'], 0, 40) . '...' : $client['address'] ?></td>
                        <td><?= date('M d, Y', strtotime($client['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('clients/' . $client['id']) ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="<?= base_url('clients/' . $client['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" action="<?= base_url('clients/' . $client['id'] . '/delete') ?>" style="display:inline;">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="background: white; padding: 40px; text-align: center; border-radius: 4px;">
            <p style="color: #666; font-size: 16px;">No clients found.</p>
            <a href="<?= base_url('clients/create') ?>" class="btn btn-success" style="margin-top: 15px;">Create First Client</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
