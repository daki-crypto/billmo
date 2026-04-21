<?php
// Dashboard/Home view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div style="background: white; padding: 40px; border-radius: 4px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <?php if ($isAdmin): ?>
        <!-- Admin Dashboard -->
        <h1 style="color: #2c3e50; margin-bottom: 20px;">Admin Dashboard</h1>
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">Welcome back! Manage users, clients, and bills</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Clients</h3>
                <div class="stat-number"><?= $totalClients ?? 0 ?></div>
                <a href="<?= base_url('clients') ?>" class="btn btn-primary" style="margin-top: 10px;">View Clients</a>
            </div>
            
            <div class="stat-card">
                <h3>Total Bills</h3>
                <div class="stat-number"><?= $totalBills ?? 0 ?></div>
                <a href="<?= base_url('bills') ?>" class="btn btn-primary" style="margin-top: 10px;">View Bills</a>
            </div>
            
            <div class="stat-card">
                <h3>Total Revenue</h3>
                <div class="stat-number">₱<?= number_format($totalRevenue ?? 0, 2) ?></div>
                <p style="color: #666; font-size: 12px; margin-top: 5px;">From all bills</p>
            </div>
            
            <div class="stat-card">
                <h3>Users</h3>
                <div class="stat-number" style="color: #dc3545;"><?= $totalUsers ?? 0 ?></div>
                <a href="<?= base_url('users') ?>" class="btn btn-primary" style="margin-top: 10px;">Manage Users</a>
            </div>
        </div>
        
        <div style="margin-top: 40px;">
            <h2 style="color: #2c3e50; margin-bottom: 20px;">Admin Actions</h2>
            <a href="<?= base_url('users') ?>" class="btn btn-danger">View All Users</a>
            <a href="<?= base_url('users/create') ?>" class="btn btn-success">Create New User</a>
            <a href="<?= base_url('clients/create') ?>" class="btn btn-primary">Add Client</a>
            <a href="<?= base_url('audit') ?>" class="btn btn-primary">View Audit Logs</a>
        </div>
    <?php else: ?>
        <!-- Normal User Dashboard -->
        <h1 style="color: #2c3e50; margin-bottom: 20px;">Welcome, <?= session()->get('user_name') ?></h1>
        <p style="font-size: 16px; color: #666; margin-bottom: 30px;">Compute and manage your electric bills</p>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Bills Computed</h3>
                <div class="stat-number"><?= $totalBillsComputed ?? 0 ?></div>
                <a href="<?= base_url('billing/history') ?>" class="btn btn-primary" style="margin-top: 10px;">View History</a>
            </div>
            
            <div class="stat-card">
                <h3>Total Billed Amount</h3>
                <div class="stat-number">₱<?= number_format($totalEarnings ?? 0, 2) ?></div>
                <p style="color: #666; font-size: 12px; margin-top: 5px;">From your bills</p>
            </div>
        </div>
        
        <div style="margin-top: 40px;">
            <h2 style="color: #2c3e50; margin-bottom: 20px;">Quick Actions</h2>
            <a href="<?= base_url('billing/compute') ?>" class="btn btn-success">+ Compute New Bill</a>
            <a href="<?= base_url('billing/history') ?>" class="btn btn-primary">View My Bills</a>
            <a href="<?= base_url('audit') ?>" class="btn btn-primary">View My Logs</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
