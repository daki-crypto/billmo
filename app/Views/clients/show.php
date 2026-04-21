<?php
// Show client view with bills
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('clients') ?>" style="color: #007bff; text-decoration: none;">← Back to Clients</a>
    </div>

    <div style="background: white; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 20px;">
        <h1 style="color: #2c3e50; margin-bottom: 20px;"><?= $client['name'] ?></h1>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Client ID</label>
                <p style="font-size: 16px; font-weight: bold;"><?= format_six_digit_id($client['id']) ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Meter Number</label>
                <p style="font-size: 16px; font-weight: bold;"><?= $client['meter_number'] ?></p>
            </div>
            <div>
                <label style="color: #666; font-size: 12px; text-transform: uppercase;">Created At</label>
                <p style="font-size: 16px; font-weight: bold;"><?= date('M d, Y', strtotime($client['created_at'])) ?></p>
            </div>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="color: #666; font-size: 12px; text-transform: uppercase;">Address</label>
            <p style="font-size: 16px; line-height: 1.6;"><?= nl2br($client['address']) ?></p>
        </div>

        <div>
            <a href="<?= base_url('clients/' . $client['id'] . '/edit') ?>" class="btn btn-primary">Edit Client</a>
            <form method="POST" action="<?= base_url('clients/' . $client['id'] . '/delete') ?>" style="display:inline;">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Client</button>
            </form>
        </div>
    </div>

    <div style="background: white; padding: 30px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="color: #2c3e50; margin-bottom: 20px;">Bills for <?= $client['name'] ?></h2>

        <?php if (!empty($client['bills'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Bill ID</th>
                        <th>Billing Month</th>
                        <th>Units</th>
                        <th>Rate/Unit</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client['bills'] as $bill): ?>
                        <tr>
                            <td><?= format_six_digit_id($bill['id']) ?></td>
                            <td><?= date('M Y', strtotime($bill['billing_month'])) ?></td>
                            <td><?= number_format($bill['units_consumed'], 2) ?></td>
                            <td>₱<?= number_format($bill['rate_per_unit'], 2) ?></td>
                            <td style="font-weight: bold; color: #007bff;">₱<?= number_format($bill['total_amount'], 2) ?></td>
                            <td>
                                <a href="<?= base_url('bills/' . $bill['id']) ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="<?= base_url('bills/' . $bill['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="color: #666; text-align: center; padding: 20px;">No bills found for this client.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
