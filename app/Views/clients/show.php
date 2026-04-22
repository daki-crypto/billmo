<?php
// Show client view with bills
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="page-container-xl">
    <div class="spacer-bottom-20">
        <a href="<?= base_url('clients') ?>" class="back-link">← Back to Clients</a>
    </div>

    <div class="info-panel spacer-bottom-20">
        <h1 class="page-title"><?= $client['name'] ?></h1>

        <div class="field-grid-two">
            <div>
                <label class="field-label-muted">Client ID</label>
                <p class="field-value"><?= format_six_digit_id($client['id']) ?></p>
            </div>
            <div>
                <label class="field-label-muted">Meter Number</label>
                <p class="field-value"><?= $client['meter_number'] ?></p>
            </div>
            <div>
                <label class="field-label-muted">Created At</label>
                <p class="field-value"><?= date('M d, Y', strtotime($client['created_at'])) ?></p>
            </div>
        </div>

        <div class="spacer-bottom-20">
            <label class="field-label-muted">Address</label>
            <p class="field-value"><?= nl2br($client['address']) ?></p>
        </div>

        <div>
            <a href="<?= base_url('clients/' . $client['id'] . '/edit') ?>" class="btn btn-primary">Edit Client</a>
            <form method="POST" action="<?= base_url('clients/' . $client['id'] . '/delete') ?>" class="inline-form">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Client</button>
            </form>
        </div>
    </div>

    <div class="info-panel">
        <h2 class="page-title">Bills for <?= $client['name'] ?></h2>

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
                            <td class="amount-cell">₱<?= number_format($bill['total_amount'], 2) ?></td>
                            <td>
                                <a href="<?= base_url('bills/' . $bill['id']) ?>" class="btn btn-primary btn-sm">View</a>
                                <a href="<?= base_url('bills/' . $bill['id'] . '/edit') ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty-state-text">No bills found for this client.</p>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
