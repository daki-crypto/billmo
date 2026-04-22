<?php
// Dashboard/Home view
?>
<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/ui/dashboard.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="dashboard-shell">
    <section class="dashboard-hero">
        <div>
            <h1>WELCOME!</h1>
            <h2><?= esc((string) (session()->get('user_name') ?: 'USER')) ?></h2>
        </div>

        <div class="dashboard-actions">
            <?php if ($isAdmin): ?>
                <a href="<?= base_url('users/create') ?>" class="btn btn-secondary">Create User</a>
            <?php else: ?>
                <a href="<?= base_url('billing/compute') ?>" class="btn btn-primary">+ Compute Bill</a>
            <?php endif; ?>
        </div>
    </section>

    <?php if ($isAdmin): ?>
        <section class="dashboard-stats">
            <article class="dashboard-card dashboard-stat featured">
                <span class="dash-stat-label">Total Clients</span>
                <div class="dash-stat-value"><?= $totalClients ?? 0 ?></div>
                <div class="dash-stat-note">Registered service accounts</div>
                <span class="dash-stat-arrow">↗</span>
            </article>

            <article class="dashboard-card dashboard-stat">
                <span class="dash-stat-label">Total Bills</span>
                <div class="dash-stat-value"><?= $totalBills ?? 0 ?></div>
                <div class="dash-stat-note">Processed billing records</div>
                <span class="dash-stat-arrow">↗</span>
            </article>

            <article class="dashboard-card dashboard-stat">
                <span class="dash-stat-label">Registered Users</span>
                <div class="dash-stat-value"><?= $totalUsers ?? 0 ?></div>
                <div class="dash-stat-note"><?= $activeUserCount ?? 0 ?> users have generated bills</div>
                <span class="dash-stat-arrow">↗</span>
            </article>

            <article class="dashboard-card dashboard-stat">
                <span class="dash-stat-label">Total Revenue</span>
                <div class="dash-stat-value">₱<?= number_format($totalRevenue ?? 0, 2) ?></div>
                <div class="dash-stat-note">Combined amount from all bills</div>
                <span class="dash-stat-arrow">↗</span>
            </article>
        </section>

        <section class="dashboard-panels">
            <div class="dashboard-stack">
                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Revenue Analytics</h3>
                            <div class="card-subtitle">Number of billed records across the last six months.</div>
                        </div>
                        <span class="mini-pill">Monthly Flow</span>
                    </div>

                    <div class="chart-bars">
                        <?php foreach (($monthlyRevenueSeries ?? []) as $series): ?>
                            <div class="chart-bar-col">
                                <span class="chart-month"><?= esc($series['label']) ?></span>
                                <div class="chart-bar" style="--bar-height: <?= (int) ($series['height'] ?? 18) ?>%;"></div>
                                <span class="chart-count"><?= (int) ($series['count'] ?? 0) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>

                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Recent Bill Activity</h3>
                            <div class="card-subtitle">Latest client billing records submitted in the system.</div>
                        </div>
                        <a href="<?= base_url('bills') ?>" class="mini-pill">View All Bills</a>
                    </div>

                    <?php if (! empty($recentBills)): ?>
                        <div class="billing-list">
                            <?php foreach ($recentBills as $bill): ?>
                                <div class="billing-item">
                                    <div>
                                        <strong><?= esc($bill['client_name'] ?? 'Client Record') ?></strong>
                                        <small><?= esc($bill['user_name'] ?? 'System User') ?> · <?= date('M d, Y', strtotime((string) $bill['billing_month'])) ?></small>
                                    </div>
                                    <div class="billing-amount">₱<?= number_format((float) ($bill['total_amount'] ?? 0), 2) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">No billing records yet.</div>
                    <?php endif; ?>
                </article>
            </div>

            <div class="dashboard-stack">
                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Workspace Pulse</h3>
                            <div class="card-subtitle">A quick read on current billing system activity.</div>
                        </div>
                    </div>

                    <div class="metric-block">
                        <span>Top Client by Revenue</span>
                        <strong><?= esc($topClient['name'] ?? 'No client data') ?></strong>
                        <p><?= isset($topClient['amount']) ? '₱' . number_format((float) $topClient['amount'], 2) . ' accumulated billed amount' : 'Create bills to surface your top client.' ?></p>
                    </div>

                    <div class="metric-block no-bottom-margin">
                        <span>Suggested Actions</span>
                        <div class="compact-actions">
                            <a href="<?= base_url('clients') ?>" class="btn btn-secondary btn-sm">Manage Clients</a>
                            <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">Manage Users</a>
                            <a href="<?= base_url('audit') ?>" class="btn btn-secondary btn-sm">Open Logs</a>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    <?php else: ?>
        <section class="dashboard-stats normal-user-stats">
            <article class="dashboard-card dashboard-stat featured">
                <span class="dash-stat-label">Bills Computed</span>
                <div class="dash-stat-value"><?= $totalBillsComputed ?? 0 ?></div>
                <div class="dash-stat-note">Billing records under your account</div>
                <span class="dash-stat-arrow">↗</span>
            </article>

            <article class="dashboard-card dashboard-stat">
                <span class="dash-stat-label">Total Billed Amount</span>
                <div class="dash-stat-value">₱<?= number_format($totalEarnings ?? 0, 2) ?></div>
                <div class="dash-stat-note">Cumulative billing amount</div>
                <span class="dash-stat-arrow">↗</span>
            </article>

            <article class="dashboard-card dashboard-stat">
                <span class="dash-stat-label">Average Bill</span>
                <div class="dash-stat-value">₱<?= number_format($averageBillAmount ?? 0, 2) ?></div>
                <div class="dash-stat-note">Average amount per billing record</div>
                <span class="dash-stat-arrow">↗</span>
            </article>
        </section>

        <section class="dashboard-panels">
            <div class="dashboard-stack">
                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Billing Trend</h3>
                            <div class="card-subtitle">Your billed totals across the last six months.</div>
                        </div>
                        <span class="mini-pill">Personal View</span>
                    </div>

                    <div class="chart-bars">
                        <?php foreach (($monthlyRevenueSeries ?? []) as $series): ?>
                            <div class="chart-bar-col">
                                <span class="chart-month"><?= esc($series['label']) ?></span>
                                <div class="chart-bar" style="--bar-height: <?= (int) ($series['height'] ?? 18) ?>%;"></div>
                                <span class="chart-count"><?= (int) ($series['count'] ?? 0) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>

                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Recent Bills</h3>
                            <div class="card-subtitle">Most recent client bill records you created.</div>
                        </div>
                    </div>

                    <?php if (! empty($recentBills)): ?>
                        <div class="billing-list">
                            <?php foreach ($recentBills as $bill): ?>
                                <div class="billing-item">
                                    <div>
                                        <strong><?= esc($bill['client_name'] ?? 'Client Record') ?></strong>
                                        <small><?= esc($bill['meter_number'] ?? 'No meter') ?> · <?= date('M d, Y', strtotime((string) $bill['billing_month'])) ?></small>
                                    </div>
                                    <div class="billing-amount">₱<?= number_format((float) ($bill['total_amount'] ?? 0), 2) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">No bills have been computed yet.</div>
                    <?php endif; ?>
                </article>
            </div>

            <div class="dashboard-stack">
                <article class="dashboard-card">
                    <div class="card-title-row">
                        <div>
                            <h3>Quick Actions</h3>
                            <div class="card-subtitle">Jump straight into your most common workflow.</div>
                        </div>
                    </div>

                    <div class="project-list">
                        <div class="project-item">
                            <div>
                                <strong>Compute New Bill</strong>
                                <small>Create a fresh billing entry for a client account.</small>
                            </div>
                            <a href="<?= base_url('billing/compute') ?>" class="btn btn-primary btn-sm">Open</a>
                        </div>

                        <div class="project-item">
                            <div>
                                <strong>Audit Activity</strong>
                                <small>See tracked actions tied to your account.</small>
                            </div>
                            <a href="<?= base_url('audit') ?>" class="btn btn-secondary btn-sm">Open</a>
                        </div>
                    </div>
                </article>

            </div>
        </section>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
