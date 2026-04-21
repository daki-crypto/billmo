<?php
// Bills index view (updated)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="color: #2c3e50;">Bills Management</h1>
    </div>

    <?php if (!empty($bills)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client Name</th>
                    <th>Meter Number</th>
                    <th>Billing Month</th>
                    <th>Units</th>
                    <th>Rate/Unit</th>
                    <th>Total Amount</th>
                    <th>Created By</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?= format_six_digit_id($bill['id']) ?></td>
                        <td><?= $bill['client_name'] ?></td>
                        <td><span class="badge badge-info"><?= $bill['meter_number'] ?></span></td>
                        <td><?= date('M Y', strtotime($bill['billing_month'])) ?></td>
                        <td><?= number_format($bill['units_consumed'], 2) ?></td>
                        <td>₱<?= number_format($bill['rate_per_unit'], 2) ?></td>
                        <td style="font-weight: bold; color: #007bff;">₱<?= number_format($bill['total_amount'], 2) ?></td>
                        <td><?= $bill['user_name'] ?></td>
                        <td>
                            <a href="<?= base_url('bills/' . $bill['id']) ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="background: white; padding: 40px; text-align: center; border-radius: 4px;">
            <p style="color: #666; font-size: 16px;">No bills from normal users found.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
