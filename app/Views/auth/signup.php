<?php
// Signup/Registration view
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - E-Billing System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .signup-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .signup-header {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .signup-header h1 {
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .signup-header p {
            color: #666;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: inherit;
        }
        
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.25);
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        .btn-secondary {
            background-color: #95a5a6;
            margin-top: 10px;
        }
        
        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
        
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            border-left: 4px solid;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        
        .alert ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        
        .alert li {
            margin-bottom: 5px;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .login-link a {
            color: #3498db;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .login-link a:hover {
            color: #2980b9;
            text-decoration: underline;
        }
        
        .password-requirements {
            background-color: #f0f8ff;
            color: #0c5460;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 12px;
            border-left: 4px solid #0c5460;
        }
        
        .password-requirements ul {
            margin-left: 20px;
            margin-top: 8px;
        }
        
        .password-requirements li {
            margin-bottom: 4px;
        }
        
        .form-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .form-buttons button,
        .form-buttons a {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s;
        }
        
        .form-buttons button {
            background-color: #28a745;
            color: white;
        }
        
        .form-buttons button:hover {
            background-color: #218838;
        }
        
        .form-buttons a {
            background-color: #6c757d;
            color: white;
        }
        
        .form-buttons a:hover {
            background-color: #5a6268;
        }

        .password-mask-text {
            -webkit-text-security: disc;
        }
    </style>
    <script>
        function enablePasswordField(field) {
            field.type = 'password';
            field.classList.remove('password-mask-text');
            field.removeAttribute('readonly');
        }

        function disablePasswordField(field) {
            if (field.value === '') {
                field.type = 'text';
                field.classList.add('password-mask-text');
                field.setAttribute('readonly', 'readonly');
            }
        }

        function clearInjectedPasswords() {
            document.querySelectorAll('input[data-password-field="true"], input[type="password"]').forEach(function(field) {
                field.value = '';
                if (field.dataset.passwordField === 'true') {
                    field.type = 'text';
                    field.classList.add('password-mask-text');
                    field.setAttribute('readonly', 'readonly');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            clearInjectedPasswords();
            [100, 300, 700].forEach(function(delay) {
                setTimeout(clearInjectedPasswords, delay);
            });
        });

        window.addEventListener('pageshow', clearInjectedPasswords);
        window.addEventListener('load', clearInjectedPasswords);
    </script>
</head>
<body>
    <div class="signup-container">
        <div class="logo"><strong>⚡BILL MO</strong></div>
        
        <div class="signup-header">
            <h1>Create Account</h1>
            <p>Join as a Normal User</p>
        </div>
        
        <?php if (session()->has('error')): ?>
            <div class="alert alert-error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
        
        <?php if (session()->has('errors')): ?>
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= base_url('auth/processSignup') ?>" autocomplete="off">
            <!-- Autofill prevention: hidden fake fields -->
            <input type="text" name="fakeusernameremembered" style="display:none" autocomplete="off">
            <input type="password" name="fakepasswordremembered" style="display:none" autocomplete="off">
            <?= csrf_field() ?>
            
            <div class="form-group">
                <label for="name">Full Name <span style="color: red;">*</span></label>
                <input type="text" id="name" name="name" value="<?= old('name') ?>" placeholder="John Doe" required autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="email">Email Address <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="john@example.com" required autocomplete="off">
            </div>
            
            <div class="form-group">
                <label for="password">Password <span style="color: red;">*</span></label>
                <input type="text" id="password" name="password" placeholder="At least 8 chars with Aa1!" required autocomplete="off" readonly data-password-field="true" class="password-mask-text" onfocus="enablePasswordField(this);" onblur="disablePasswordField(this);">
            </div>
            
            <div class="password-requirements">
                <strong>Password Requirements:</strong>
                <ul>
                    <li>Minimum 8 characters</li>
                    <li>At least 1 uppercase letter</li>
                    <li>At least 1 lowercase letter</li>
                    <li>At least 1 number</li>
                    <li>At least 1 special character</li>
                </ul>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password <span style="color: red;">*</span></label>
                <input type="text" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required autocomplete="off" readonly data-password-field="true" class="password-mask-text" onfocus="enablePasswordField(this);" onblur="disablePasswordField(this);">
            </div>
            
            <button type="submit" class="btn">Create Account</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="<?= base_url('auth/login') ?>">Login here</a></p>
        </div>
    </div>
</body>
</html>
