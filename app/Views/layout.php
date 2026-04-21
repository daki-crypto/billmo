<?php
// Layout template
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Billing System' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --app-bg: #eff3eb;
            --surface: #ffffff;
            --surface-soft: #f8fbf5;
            --surface-strong: #f2f6ef;
            --text-main: #14231d;
            --text-muted: #6d7b72;
            --line: rgba(20, 35, 29, 0.08);
            --accent: #176a43;
            --accent-strong: #0f4c30;
            --accent-soft: #dff1e6;
            --warning: #eca63d;
            --danger: #d85a5a;
            --shadow-soft: 0 18px 45px rgba(20, 35, 29, 0.08);
            --shadow-card: 0 8px 24px rgba(20, 35, 29, 0.06);
        }

        body {
            font-family: 'Trebuchet MS', 'Segoe UI', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(23, 106, 67, 0.12), transparent 28%),
                linear-gradient(180deg, #f7faf5 0%, var(--app-bg) 100%);
            color: var(--text-main);
            min-height: 100vh;
        }

        a {
            color: inherit;
        }

        .app-shell {
            display: flex;
            min-height: 100vh;
            gap: 24px;
            padding: 20px;
        }

        .sidebar {
            width: 250px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.7);
            border-radius: 28px;
            padding: 28px 20px;
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            position: sticky;
            top: 20px;
            height: calc(100vh - 40px);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 30px;
            padding: 6px 8px;
        }

        .brand-mark {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, #1c7d52, #0f4c30);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .brand-text strong {
            display: block;
            font-size: 18px;
            letter-spacing: 0.02em;
        }

        .brand-text span {
            color: var(--text-muted);
            font-size: 12px;
        }

        .sidebar-group {
            margin-bottom: 28px;
        }

        .sidebar-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: #8c988f;
            margin: 0 12px 14px;
        }

        .sidebar-nav {
            display: grid;
            gap: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            transition: all 0.25s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--text-main);
            background: var(--surface-soft);
            transform: translateX(3px);
        }

        .nav-link.active {
            box-shadow: inset 3px 0 0 var(--accent);
        }

        .nav-dot {
            width: 18px;
            text-align: center;
            color: var(--accent);
            font-size: 15px;
        }

        .main-shell {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
        }

        /* .topbar-search and .topbar-search input styles removed */

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
            justify-content: flex-end;
        }

        .topbar-icon,
        .profile-trigger {
            border: 1px solid var(--line);
            background: var(--surface);
            border-radius: 16px;
            min-height: 48px;
            padding: 0 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            box-shadow: var(--shadow-card);
        }

        .topbar-icon {
            width: 48px;
            padding: 0;
            font-size: 18px;
        }

        .profile-trigger {
            gap: 12px;
            color: var(--text-main);
        }

        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e8ba8d, #b16558);
            color: #fff;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .profile-meta strong {
            display: block;
            font-size: 14px;
        }

        .profile-meta span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .container {
            width: 100%;
            max-width: none;
            padding: 0;
        }

        .alert {
            padding: 16px 18px;
            margin-bottom: 16px;
            border-radius: 18px;
            border: 1px solid transparent;
            box-shadow: var(--shadow-card);
        }

        .alert-success {
            background-color: #edf8f0;
            color: #1f6b3b;
            border-color: rgba(40, 167, 69, 0.14);
        }

        .alert-danger {
            background-color: #fdf1f1;
            color: #8d3434;
            border-color: rgba(216, 90, 90, 0.16);
        }

        .btn {
            padding: 12px 18px;
            margin: 0;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.25s ease;
            box-shadow: var(--shadow-card);
        }

        .btn-primary {
            background-color: var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--accent-strong);
        }

        .btn-success {
            background-color: var(--accent-strong);
            color: #fff;
        }

        .btn-success:hover {
            filter: brightness(1.05);
        }

        .btn-danger {
            background-color: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            filter: brightness(1.05);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--text-main);
            border: 1px solid var(--line);
        }

        .btn-secondary:hover {
            background-color: var(--surface-soft);
        }

        .btn-sm {
            padding: 8px 14px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface);
            box-shadow: var(--shadow-card);
            margin: 20px 0;
            border-radius: 22px;
            overflow: hidden;
        }

        th {
            background-color: #1b3026;
            color: #fff;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
        }

        tr:hover {
            background-color: var(--surface-soft);
        }

        .form-container {
            background: var(--surface);
            padding: 30px;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-main);
        }

        input, select, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 16px;
            font-family: inherit;
            font-size: 14px;
            transition: border-color 0.3s;
            background: var(--surface-soft);
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: rgba(23, 106, 67, 0.4);
            box-shadow: 0 0 0 4px rgba(23, 106, 67, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-info {
            background-color: var(--accent-soft);
            color: var(--accent-strong);
        }

        .breadcrumb {
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
            margin: 0 5px;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .stat-card {
            background: var(--surface);
            padding: 20px;
            border-radius: 24px;
            box-shadow: var(--shadow-card);
            text-align: center;
        }

        .stat-card h3 {
            color: var(--text-main);
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: var(--accent);
        }

        @media (max-width: 1080px) {
            .app-shell {
                flex-direction: column;
                padding: 14px;
            }

            .sidebar {
                width: 100%;
                height: auto;
                position: static;
            }
        }

        @media (max-width: 640px) {
            .topbar,
            .profile-trigger {
                border-radius: 22px;
            }

            .topbar-actions {
                width: auto;
                margin-left: auto;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

            .form-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php $currentPath = trim(uri_string(), '/'); ?>
    <div class="app-shell">
        <aside class="sidebar">
            <div>
                <div class="brand">
                    <span class="brand-mark">⚡</span>
                    <div class="brand-text">
                        <strong>Bill Mo</strong>
                        <span>Bayaran Mo</span>
                    </div>
                </div>

                <div class="sidebar-group">
                    <div class="sidebar-label">Menu</div>
                    <nav class="sidebar-nav">
                        <a class="nav-link <?= $currentPath === '' ? 'active' : '' ?>" href="<?= base_url('/') ?>"><span class="nav-dot">◉</span>Dashboard</a>
                        <?php if (session()->get('user_role') === 'admin'): ?>
                            <a class="nav-link <?= str_starts_with($currentPath, 'clients') ? 'active' : '' ?>" href="<?= base_url('clients') ?>"><span class="nav-dot">◎</span>Clients</a>
                            <a class="nav-link <?= str_starts_with($currentPath, 'bills') ? 'active' : '' ?>" href="<?= base_url('bills') ?>"><span class="nav-dot">◌</span>Bills</a>
                            <a class="nav-link <?= str_starts_with($currentPath, 'users') ? 'active' : '' ?>" href="<?= base_url('users') ?>"><span class="nav-dot">◍</span>Users</a>
                        <?php else: ?>
                            <a class="nav-link <?= str_starts_with($currentPath, 'billing/compute') ? 'active' : '' ?>" href="<?= base_url('billing/compute') ?>"><span class="nav-dot">◎</span>Compute Bill</a>
                            <a class="nav-link <?= str_starts_with($currentPath, 'billing/history') ? 'active' : '' ?>" href="<?= base_url('billing/history') ?>"><span class="nav-dot">◌</span>History</a>
                        <?php endif; ?>
                    </nav>
                </div>

                <div class="sidebar-group">
                    <div class="sidebar-label">General</div>
                    <nav class="sidebar-nav">
                        <a class="nav-link <?= str_starts_with($currentPath, 'audit') ? 'active' : '' ?>" href="<?= base_url('audit') ?>"><span class="nav-dot">◔</span>Audit Logs</a>
                        <a class="nav-link <?= str_starts_with($currentPath, 'profile') ? 'active' : '' ?>" href="<?= base_url('profile') ?>"><span class="nav-dot">◑</span>Profile</a>
                        <a class="nav-link" href="<?= base_url('auth/logout') ?>"><span class="nav-dot">⏻</span>Logout</a>
                    </nav>
                </div>
            </div>
        </aside>

        <div class="main-shell">
            <div class="topbar">
                <div class="topbar-actions">
                    <a href="<?= base_url('audit') ?>" class="topbar-icon" title="Audit Logs">◔</a>
                    <a href="<?= base_url('profile') ?>" class="profile-trigger">
                        <span class="profile-avatar"><?= strtoupper(substr((string) session()->get('user_name'), 0, 1)) ?></span>
                        <span class="profile-meta">
                            <strong><?= esc((string) session()->get('user_name')) ?></strong>
                            <span><?= esc((string) session()->get('user_email')) ?> · <?= ucfirst((string) session()->get('user_role')) ?></span>
                        </span>
                    </a>
                </div>
            </div>

            <div class="container">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        ✓ <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        ✗ <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Global AJAX form submission handler
            $(document).on('submit', 'form:not([data-ajax-disabled])', function(e) {
                e.preventDefault();
                const $form = $(this);
                const formData = new FormData(this);
                const url = $form.attr('action');
                const method = $form.attr('method') || 'POST';

                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            showAlert('success', response.message || 'Operation completed successfully!');
                            
                            // If there's a redirect URL, redirect after a short delay
                            if (response.redirect) {
                                setTimeout(() => {
                                    window.location.href = response.redirect;
                                }, 1500);
                            } else {
                                // Reload page if no redirect specified
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        } else {
                            showAlert('danger', response.message || 'An error occurred');
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMsg = 'An error occurred: ' + error;
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        showAlert('danger', errorMsg);
                    }
                });
            });

            // Global AJAX delete handler for delete forms
            $(document).on('submit', 'form[action*="/delete"]', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to delete this item?')) {
                    $(this).off('submit').submit();
                }
            });

            // Helper function to show alerts
            function showAlert(type, message) {
                const alertHtml = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="margin-top: 15px;">
                        ${type === 'success' ? '✓' : '✗'} ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                // Insert alert at the top of the main content area
                const $container = $('.container').first();
                if ($container.length) {
                    $container.prepend(alertHtml);
                    // Auto-remove alert after 5 seconds
                    setTimeout(() => {
                        $('.alert').not(':has(.btn-close[aria-label="Close"])').fadeOut(() => {
                            $(this).remove();
                        });
                    }, 5000);
                }
            }
        });
    </script>
</body>
</html>
