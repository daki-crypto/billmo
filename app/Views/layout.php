<?php
// Layout template
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'E-Billing System' ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            gap: 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            white-space: nowrap;
        }
        
        nav {
            display: flex;
            gap: 20px;
            flex: 1;
        }
        
        nav a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        nav a:hover {
            color: #3498db;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .alert {
            padding: 15px;
            margin: 15px 0;
            border-radius: 4px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        
        .btn {
            padding: 10px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
        }
        
        .btn-success {
            background-color: #28a745;
            color: white;
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        
        th {
            background-color: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:hover {
            background-color: #f9f9f9;
        }
        
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            max-width: 600px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #2c3e50;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0,123,255,0.25);
        }
        
        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-buttons {
            margin-top: 20px;
        }
        
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
        
        .breadcrumb {
            padding: 10px 0;
            margin-bottom: 20px;
        }
        
        .breadcrumb a {
            color: #007bff;
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
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .stat-card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">⚡BILL MO</div>
            <nav>
                <a href="<?= base_url('/') ?>">Home</a>
                <?php if (session()->get('user_role') === 'admin'): ?>
                    <a href="<?= base_url('clients') ?>">Clients</a>
                    <a href="<?= base_url('bills') ?>">Bills</a>
                <?php else: ?>
                    <a href="<?= base_url('billing/history') ?>">Bills</a>
                <?php endif; ?>
                <a href="<?= base_url('audit') ?>">Logs</a>
            </nav>
            <div style="display: flex; align-items: center; gap: 20px;">
                <?php if (session()->has('user_id')): ?>
                    <a href="<?= base_url('profile') ?>" style="color: white; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <strong><?= session()->get('user_name') ?></strong>
                        <span style="background-color: <?= session()->get('user_role') === 'admin' ? '#dc3545' : '#28a745' ?>; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-left: 8px;">
                            <?= ucfirst(session()->get('user_role')) ?>
                        </span>
                    </a>
                    <a href="<?= base_url('auth/logout') ?>" style="color: white; text-decoration: none; padding: 6px 12px; background-color: rgba(255,255,255,0.2); border-radius: 4px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.3)'" onmouseout="this.style.backgroundColor='rgba(255,255,255,0.2)'">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('auth/login') ?>" style="color: white; text-decoration: none; padding: 6px 12px; background-color: #007bff; border-radius: 4px;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

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

    <footer>
        <p>&copy; 2026 E-Billing System. All rights reserved.</p>
    </footer>
</body>
</html>
