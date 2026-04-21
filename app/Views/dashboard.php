<?php
// Dashboard/Home view
?>
<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<style>
    .dashboard-shell {
        display: grid;
        gap: 18px;
    }

    .dashboard-hero,
    .dashboard-card {
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid rgba(255, 255, 255, 0.85);
        border-radius: 28px;
        box-shadow: 0 12px 28px rgba(20, 35, 29, 0.08);
    }

    .dashboard-hero {
        padding: 28px 30px;
        display: flex;
        justify-content: space-between;
        gap: 20px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .dashboard-hero h1 {
        font-size: 42px;
        line-height: 1;
        margin-bottom: 10px;
        color: #15251e;
    }

    .dashboard-hero p {
        color: #748278;
        max-width: 640px;
        line-height: 1.6;
    }

    .dashboard-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .dashboard-stat {
        padding: 24px;
        position: relative;
        overflow: hidden;
        min-width: 0;
    }

    .dashboard-stat.featured {
        background: linear-gradient(145deg, #176a43, #0e4d30 78%);
        color: #f6fff8;
    }

    .dashboard-stat.featured .dash-stat-label,
    .dashboard-stat.featured .dash-stat-note,
    .dashboard-stat.featured .dash-stat-arrow {
        color: inherit;
        opacity: 0.92;
    }

    .dash-stat-label {
        display: block;
        font-size: 15px;
        color: #25372f;
        margin-bottom: 18px;
    }

    .dash-stat-value {
        display: block;
        max-width: 100%;
        font-size: clamp(2rem, 2.8vw, 46px);
        font-weight: 700;
        line-height: 0.95;
        letter-spacing: -0.04em;
        margin-bottom: 12px;
        color: #15251e;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .dash-stat-note {
        font-size: 13px;
        color: #7b897f;
    }

    .dash-stat-arrow {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid rgba(20, 35, 29, 0.12);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #15251e;
        background: rgba(255, 255, 255, 0.7);
    }

    .dashboard-panels {
        display: grid;
        grid-template-columns: 1.35fr 0.95fr;
        gap: 18px;
    }

    .dashboard-stack {
        display: grid;
        gap: 18px;
    }

    .dashboard-card {
        padding: 24px;
    }

    .dashboard-card h2 {
        font-size: 28px;
        margin-bottom: 8px;
        color: #14231d;
    }

    .card-title-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
        margin-bottom: 18px;
    }

    .card-title-row h3 {
        font-size: 28px;
        color: #14231d;
    }

    .card-subtitle {
        color: #7b897f;
        font-size: 14px;
        margin-bottom: 18px;
    }

    .mini-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid rgba(20, 35, 29, 0.1);
        border-radius: 999px;
        background: #fff;
        color: #31453b;
        font-size: 12px;
    }

    .chart-bars {
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        align-items: end;
        gap: 16px;
        min-height: 180px;
        padding-top: 10px;
    }

    .chart-bar-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .chart-bar {
        width: 100%;
        max-width: 54px;
        border-radius: 28px;
        background: repeating-linear-gradient(
            -45deg,
            rgba(23, 106, 67, 0.16),
            rgba(23, 106, 67, 0.16) 4px,
            rgba(255, 255, 255, 0.9) 4px,
            rgba(255, 255, 255, 0.9) 8px
        );
        position: relative;
        overflow: hidden;
    }

    .chart-bar::after {
        content: '';
        position: absolute;
        inset: auto 0 0;
        height: var(--bar-height);
        border-radius: 28px;
        background: linear-gradient(180deg, #67c99a, #176a43 85%);
    }

    .chart-bar-col span {
        color: #748278;
        font-size: 13px;
    }

    .metric-block {
        background: linear-gradient(160deg, #f5fbf7, #eef5f0);
        border-radius: 24px;
        padding: 20px;
        margin-bottom: 16px;
    }

    .metric-block strong {
        display: block;
        font-size: 32px;
        color: #14231d;
        margin-bottom: 8px;
    }

    .metric-block span,
    .metric-block p,
    .billing-list small,
    .project-list small {
        color: #7b897f;
    }

    .billing-list,
    .project-list {
        display: grid;
        gap: 14px;
    }

    .billing-item,
    .project-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(20, 35, 29, 0.08);
    }

    .billing-item:last-child,
    .project-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .billing-item strong,
    .project-item strong {
        display: block;
        color: #14231d;
        margin-bottom: 4px;
    }

    .billing-amount {
        font-size: 18px;
        font-weight: 700;
        color: #176a43;
        white-space: nowrap;
    }

    .compact-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .empty-state {
        color: #7b897f;
        font-size: 14px;
        padding: 10px 0;
    }

    @media (max-width: 1180px) {
        .dashboard-stats,
        .dashboard-panels {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-panels {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 760px) {
        .dashboard-hero {
            padding: 24px;
        }

        .dashboard-hero h1,
        .card-title-row h3 {
            font-size: 32px;
        }

        .dash-stat-value {
            font-size: clamp(1.8rem, 8vw, 2.4rem);
        }

        .dashboard-stats,
        .chart-bars {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .chart-bars {
            gap: 18px 12px;
        }
    }
</style>

<div class="dashboard-shell">
    <section class="dashboard-hero">
        <div>
            <h1>Dashboard</h1>
            <p>
                <?= $isAdmin
                    ? 'Monitor client growth, revenue flow, and billing activity from a cleaner control room.'
                    : 'Track your billing activity, keep an eye on total charges, and jump into the next bill quickly.' ?>
            </p>
        </div>

        <div class="dashboard-actions">
            <?php if ($isAdmin): ?>
                <a href="<?= base_url('clients/create') ?>" class="btn btn-primary">+ Add Client</a>
                <a href="<?= base_url('users/create') ?>" class="btn btn-secondary">Create User</a>
            <?php else: ?>
                <a href="<?= base_url('billing/compute') ?>" class="btn btn-primary">+ Compute Bill</a>
                <a href="<?= base_url('billing/history') ?>" class="btn btn-secondary">View History</a>
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
                            <div class="card-subtitle">Billing totals across the last six months.</div>
                        </div>
                        <span class="mini-pill">Monthly Flow</span>
                    </div>

                    <div class="chart-bars">
                        <?php foreach (($monthlyRevenueSeries ?? []) as $series): ?>
                            <div class="chart-bar-col">
                                <div class="chart-bar" style="height: 150px; --bar-height: <?= (int) ($series['height'] ?? 18) ?>%;"></div>
                                <span><?= esc($series['label']) ?></span>
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

                    <div class="metric-block" style="margin-bottom: 0;">
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
        <section class="dashboard-stats">
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
                <span class="dash-stat-label">Connected Clients</span>
                <div class="dash-stat-value"><?= $connectedClients ?? 0 ?></div>
                <div class="dash-stat-note">Distinct client accounts billed</div>
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
                                <div class="chart-bar" style="height: 150px; --bar-height: <?= (int) ($series['height'] ?? 18) ?>%;"></div>
                                <span><?= esc($series['label']) ?></span>
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
                        <a href="<?= base_url('billing/history') ?>" class="mini-pill">Open History</a>
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
                                <strong>Review Bill History</strong>
                                <small>Inspect past totals, dates, and client records.</small>
                            </div>
                            <a href="<?= base_url('billing/history') ?>" class="btn btn-secondary btn-sm">Open</a>
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
