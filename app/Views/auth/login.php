<?php
// Login view
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Billing System</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/ui/auth-login.css') ?>">
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
    <div class="login-outer">
        <div class="login-logo">
            <svg width="60" height="60" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="bolt-gradient" x1="0" y1="0" x2="32" y2="32" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#fbb034"/>
                        <stop offset="1" stop-color="#ff4e00"/>
                    </linearGradient>
                </defs>
                <circle cx="16" cy="16" r="16" fill="#176a43"/>
                <path d="M18 2L6 18H15L14 30L26 14H17L18 2Z" fill="url(#bolt-gradient)"/>
            </svg>
        </div>
        <div class="login-container">
            <div class="logo logo-tight"><strong>⚡BILL MO</strong></div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error">
                    <ul class="error-list">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('auth/processLogin') ?>" class="full-width-form" autocomplete="off">
                <?= csrf_field() ?>
                <input type="text" name="fakeusernameremembered" class="hidden-field" autocomplete="off">
                <input type="password" name="fakepasswordremembered" class="hidden-field" autocomplete="off">

                <div class="form-group">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 9a4 4 0 100-8 4 4 0 000 8zm0 2c-2.67 0-8 1.34-8 4v2a1 1 0 001 1h14a1 1 0 001-1v-2c0-2.66-5.33-4-8-4z" fill="#fff"/></svg>
                    </span>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" placeholder="Email Address" required autofocus autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
                </div>

                <div class="form-group">
                    <span class="input-icon">
                        <svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 8V6a3 3 0 10-6 0v2a2 2 0 00-2 2v4a2 2 0 002 2h6a2 2 0 002-2v-4a2 2 0 00-2-2zm-6-2a2 2 0 114 0v2H6V6zm8 6a1 1 0 01-1 1H5a1 1 0 01-1-1v-4a1 1 0 011-1h8a1 1 0 011 1v4z" fill="#fff"/></svg>
                    </span>
                    <input type="text" id="password" name="password" placeholder="Password" required autocomplete="off" readonly data-password-field="true" class="password-mask-text" onfocus="enablePasswordField(this);" onblur="disablePasswordField(this);">
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
