<?php
// Billing history view (Normal user)
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div>
    <h1 style="color: #2c3e50; margin-bottom: 20px;">My Billing History</h1>

    <div style="margin-bottom: 20px;">
        <a href="<?= base_url('billing/compute') ?>" class="btn btn-success">+ Compute New Bill</a>
    </div>

    <div class="stats-grid" style="margin-bottom: 20px;">
        <div class="stat-card">
            <h3>Total Bills</h3>
            <div class="stat-number"><?= $summary['totalBills'] ?? 0 ?></div>
        </div>
        <div class="stat-card">
            <h3>Total Amount</h3>
            <div class="stat-number">₱<?= number_format($summary['totalAmount'] ?? 0, 2) ?></div>
        </div>
        <div class="stat-card">
            <h3>Latest Bill Month</h3>
            <div style="font-size: 22px; font-weight: bold; color: #007bff;">
                <?= ! empty($summary['latestBillMonth']) ? date('M Y', strtotime($summary['latestBillMonth'])) : 'N/A' ?>
            </div>
        </div>
    </div>

    <?php if (!empty($bills)): ?>
        <table>
            <thead>
                <tr>
                    <th>Bill ID</th>
                    <th>Client</th>
                    <th>Billing Month</th>
                    <th>Units Consumed</th>
                    <th>Rate/Unit</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bills as $bill): ?>
                    <tr>
                        <td><?= format_six_digit_id($bill['id']) ?></td>
                        <td><?= $bill['client_name'] ?? 'Unknown Client' ?></td>
                        <td><?= date('M Y', strtotime($bill['billing_month'])) ?></td>
                        <td><?= number_format($bill['units_consumed'], 2) ?> kWh</td>
                        <td>₱<?= number_format($bill['rate_per_unit'], 2) ?></td>
                        <td style="font-weight: bold; color: #007bff;">₱<?= number_format($bill['total_amount'], 2) ?></td>
                        <td><?= date('M d, Y', strtotime($bill['created_at'])) ?></td>
                        <td>
                            <a href="<?= base_url('billing/summary/' . $bill['id']) ?>" class="btn btn-primary btn-sm">View Summary</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div style="background: white; padding: 40px; text-align: center; border-radius: 4px;">
            <p style="color: #666; font-size: 16px;">No billing history yet.</p>
            <a href="<?= base_url('billing/compute') ?>" class="btn btn-success" style="margin-top: 15px;">Compute Your First Bill</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
