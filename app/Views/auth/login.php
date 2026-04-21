<?php
// Login view
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Billing System</title>
    <style>
        :root {
            --app-bg: #eff3eb;
            --surface: rgba(255, 255, 255, 0.92);
            --surface-strong: #ffffff;
            --text-main: #14231d;
            --text-muted: #6d7b72;
            --line: rgba(20, 35, 29, 0.1);
            --accent: #176a43;
            --accent-strong: #0f4c30;
            --accent-soft: #dff1e6;
            --shadow-soft: 0 18px 45px rgba(20, 35, 29, 0.08);
            --shadow-card: 0 10px 28px rgba(20, 35, 29, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Trebuchet MS', 'Segoe UI', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(23, 106, 67, 0.12), transparent 28%),
                linear-gradient(180deg, #f7faf5 0%, var(--app-bg) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
        }

        .login-outer {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px;
        }

        .login-logo {
            width: 90px;
            height: 90px;
            background: var(--surface-strong);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-soft);
            margin-bottom: -45px;
            z-index: 2;
            position: relative;
        }

        .login-container {
            background: var(--surface);
            border: 1px solid rgba(255, 255, 255, 0.85);
            padding: 56px 36px 36px;
            border-radius: 28px;
            box-shadow: var(--shadow-card);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            backdrop-filter: blur(18px);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 28px;
            font-size: 34px;
            font-weight: bold;
            color: var(--text-main);
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .input-icon {
            background: linear-gradient(135deg, #1c7d52, #0f4c30);
            color: #fff;
            padding: 0 14px;
            border-radius: 16px 0 0 16px;
            height: 50px;
            display: flex;
            align-items: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 0 16px 16px 0;
            font-size: 15px;
            transition: border-color 0.3s;
            height: 50px;
            background: #f8fbf5;
            color: var(--text-main);
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(23, 106, 67, 0.4);
            box-shadow: 0 0 0 4px rgba(23, 106, 67, 0.1);
        }

        .remember-row {
            display: flex;
            align-items: center;
            margin-bottom: 18px;
            width: 100%;
        }

        .remember-row input[type="checkbox"] {
            margin-right: 8px;
            accent-color: var(--accent);
        }

        .remember-row label {
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 400;
        }

        .btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--accent), var(--accent-strong));
            color: #fff;
            border: none;
            border-radius: 999px;
            font-size: 17px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: var(--shadow-card);
            transition: transform 0.2s ease, filter 0.2s ease;
        }

        .btn:hover {
            filter: brightness(1.04);
            transform: translateY(-1px);
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 16px;
            border: 1px solid transparent;
            width: 100%;
        }

        .alert-error {
            background-color: #fdf1f1;
            color: #8d3434;
            border-color: rgba(216, 90, 90, 0.16);
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
            <div class="logo" style="margin-bottom: 18px; margin-top: 10px;"><strong>⚡BILL MO</strong></div>

            <?php if (session()->has('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->has('errors')): ?>
                <div class="alert alert-error">
                    <ul style="margin-left: 20px;">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?= base_url('auth/processLogin') ?>" style="width: 100%;" autocomplete="off">
                <?= csrf_field() ?>
                <input type="text" name="fakeusernameremembered" style="display:none" autocomplete="off">
                <input type="password" name="fakepasswordremembered" style="display:none" autocomplete="off">

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
