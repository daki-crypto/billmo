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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/ui/layout.css') ?>">
    <?= $this->renderSection('styles') ?>
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
                            <a class="nav-link <?= str_starts_with($currentPath, 'bills') ? 'active' : '' ?>" href="<?= base_url('bills') ?>"><span class="nav-dot">◌</span>Bills</a>
                            <a class="nav-link <?= str_starts_with($currentPath, 'users') ? 'active' : '' ?>" href="<?= base_url('users') ?>"><span class="nav-dot">◍</span>Users</a>
                        <?php else: ?>
                            <a class="nav-link <?= str_starts_with($currentPath, 'billing/compute') ? 'active' : '' ?>" href="<?= base_url('billing/compute') ?>"><span class="nav-dot">◎</span>Compute Bill</a>
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
        // Sync CSRF token from cookie into all forms after each AJAX response
        function refreshCsrfTokens() {
            const match = document.cookie.match(/csrf_cookie_name=([^;]+)/);
            if (match) {
                const token = decodeURIComponent(match[1]);
                $('input[name="csrf_test_name"]').val(token);
            }
        }

        $(document).ready(function() {
            // Global AJAX form submission handler
            $(document).on('submit', 'form:not([data-ajax-disabled])', function(e) {
                e.preventDefault();
                const $form = $(this);
                // Always read the latest CSRF token from cookie before sending
                refreshCsrfTokens();
                const formData = new FormData($form[0]);
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
                        refreshCsrfTokens();
                        if (response.success) {
                            showAlert('success', response.message || 'Operation completed successfully!');
                            if (response.redirect) {
                                setTimeout(() => { window.location.href = response.redirect; }, 1500);
                            } else {
                                setTimeout(() => { location.reload(); }, 1500);
                            }
                        } else {
                            // Show field-level errors if present, otherwise show the message
                            if (response.errors && Object.keys(response.errors).length > 0) {
                                const errorList = Object.values(response.errors).map(e => `<li>${e}</li>`).join('');
                                showAlert('danger', `${response.message || 'Please fix the following errors'}:<ul class="ajax-error-list">${errorList}</ul>`);
                            } else {
                                showAlert('danger', response.message || 'An error occurred');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        refreshCsrfTokens();
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
                    <div class="alert alert-${type} alert-dismissible fade show alert-top-spacing" role="alert">
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
