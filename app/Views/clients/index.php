<?php
// Clients index view (updated)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <div class="page-header-row">
        <h1 class="page-title-no-margin">Clients Management</h1>
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
                        <td class="field-value"><?= $client['name'] ?></td>
                        <td><span class="badge badge-info"><?= $client['meter_number'] ?></span></td>
                        <td><?= strlen($client['address']) > 40 ? substr($client['address'], 0, 40) . '...' : $client['address'] ?></td>
                        <td><?= date('M d, Y', strtotime($client['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('clients/' . $client['id']) ?>" class="btn btn-primary btn-sm">View</a>
                            <a href="<?= base_url('clients/' . $client['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" action="<?= base_url('clients/' . $client['id'] . '/delete') ?>" class="inline-form">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state-card">
            <p class="empty-state-text">No clients found.</p>
            <a href="<?= base_url('clients/create') ?>" class="btn btn-success top-gap-15">Create First Client</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
