<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>EMIS Login</title>

    <style>
        :root {
            --primary: #1d4ed8;
            --primary-dark: #173d7a;
            --primary-light: #e8f0ff;

            --page-background: #f1f4f8;
            --card-background: #ffffff;

            --text-dark: #111827;
            --text-muted: #64748b;

            --border-color: #cbd5e1;
            --danger: #b91c1c;
            --danger-background: #fff1f2;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            padding: 85px 20px 30px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-family:
                "Segoe UI",
                Tahoma,
                Arial,
                sans-serif;

            color: var(--text-dark);

            background:
                radial-gradient(
                    circle at top left,
                    rgba(29, 78, 216, 0.07),
                    transparent 32%
                ),
                var(--page-background);
        }

        .login-container {
            width: 100%;
            max-width: 655px;
        }

        .login-box {
            position: relative;
            overflow: visible;

            width: 100%;
            padding: 76px 42px 38px;

            background: var(--card-background);

            border: 1px solid rgba(15, 23, 42, 0.06);
            border-radius: 20px;

            box-shadow:
                0 20px 50px rgba(15, 23, 42, 0.10),
                0 5px 15px rgba(15, 23, 42, 0.05);
        }

        /* =========================================================
           LOGO
           ========================================================= */

        .logo-wrapper {
            position: absolute;
            top: -55px;
            left: 50%;
            z-index: 10;

            width: 110px;
            height: 110px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform: translateX(-50%);

            background: #ffffff;
            border: 5px solid var(--primary-light);
            border-radius: 50%;

            box-shadow:
                0 12px 30px rgba(23, 61, 122, 0.20);
        }

        .logo {
            display: block;

            width: 82px;
            height: 82px;
            max-width: 82px;

            object-fit: contain;
        }

        /* =========================================================
           HEADER
           ========================================================= */

        .login-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .login-header h1 {
            margin: 0 0 8px;

            color: var(--primary-dark);

            font-size: 34px;
            font-weight: 750;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }

        .login-header p {
            margin: 0;

            color: #566170;

            font-size: 18px;
            line-height: 1.5;
        }

        /* =========================================================
           ALERTS
           ========================================================= */

        .alert {
            margin-bottom: 20px;
            padding: 12px 14px;

            color: var(--danger);
            background: var(--danger-background);

            border: 1px solid #fecdd3;
            border-radius: 9px;

            font-size: 13px;
            line-height: 1.6;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        /* =========================================================
           FORM
           ========================================================= */

        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;

            color: #050505;

            font-size: 17px;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            height: 56px;
            padding: 12px 16px;

            color: var(--text-dark);
            background: #f8fbff;

            border: 1px solid var(--border-color);
            border-radius: 12px;

            font-family: inherit;
            font-size: 17px;

            outline: none;

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                background 0.2s ease;
        }

        .form-control:hover {
            border-color: #94a3b8;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary);

            box-shadow:
                0 0 0 4px rgba(29, 78, 216, 0.12);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .invalid-feedback {
            margin-top: 6px;

            color: var(--danger);

            font-size: 12px;
            line-height: 1.4;
        }

        /* =========================================================
           PASSWORD FIELD
           ========================================================= */

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 72px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 9px;

            min-width: 52px;
            height: 38px;
            padding: 0 9px;

            transform: translateY(-50%);

            color: var(--primary-dark);
            background: transparent;

            border: 0;
            border-radius: 8px;

            font-family: inherit;
            font-size: 12px;
            font-weight: 700;

            cursor: pointer;
        }

        .password-toggle:hover {
            background: var(--primary-light);
        }

        /* =========================================================
           OPTIONS
           ========================================================= */

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
            margin: 2px 5px 26px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;

            color: #111827;

            font-size: 16px;

            cursor: pointer;
        }

        .remember-label input {
            width: 19px;
            height: 19px;
            margin: 0;

            accent-color: var(--primary);
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary-dark);

            font-size: 14px;
            font-weight: 650;

            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        /* =========================================================
           LOGIN BUTTON
           ========================================================= */

        .btn-login {
            width: 100%;
            min-height: 58px;
            padding: 13px 20px;

            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1267f3
                );

            border: 0;
            border-radius: 12px;

            font-family: inherit;
            font-size: 18px;
            font-weight: 650;

            cursor: pointer;

            box-shadow:
                0 10px 22px rgba(37, 99, 235, 0.23);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                opacity 0.2s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 28px rgba(37, 99, 235, 0.30);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.70;
            cursor: not-allowed;
            transform: none;
        }

        /* =========================================================
           FOOTER
           ========================================================= */

        .footer-text {
            margin-top: 25px;

            color: var(--text-muted);

            text-align: center;
            font-size: 11px;
            line-height: 1.7;
        }

        /* =========================================================
           RESPONSIVE
           ========================================================= */

        @media (max-width: 700px) {
            body {
                padding: 78px 15px 20px;
            }

            .login-container {
                max-width: 100%;
            }

            .login-box {
                padding:
                    68px
                    24px
                    30px;

                border-radius: 17px;
            }

            .logo-wrapper {
                top: -50px;

                width: 100px;
                height: 100px;
            }

            .logo {
                width: 74px;
                height: 74px;
            }

            .login-header h1 {
                font-size: 29px;
            }

            .login-header p {
                font-size: 15px;
            }

            .form-control {
                height: 52px;
                font-size: 15px;
            }

            .form-options {
                align-items: flex-start;
                flex-direction: column;
            }

            .btn-login {
                min-height: 53px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <main class="login-container">

        <section class="login-box">

            {{-- Logo --}}
            <div class="logo-wrapper">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="EMIS Logo"
                    class="logo"
                >
            </div>

            {{-- Heading --}}
            <header class="login-header">
                <h1>EMIS</h1>

                <p>
                    Executive Management Information System
                </p>
            </header>

            {{-- Session error --}}
            @if(session('error'))
                <div class="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if($errors->any())
                <div class="alert">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('login') }}"
                id="loginForm"
            >
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label
                        for="email"
                        class="form-label"
                    >
                        Username or Email
                    </label>

                    <input
                        type="text"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        class="form-control
                            @error('email') is-invalid @enderror"
                        autocomplete="username"
                        required
                        autofocus
                    >

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label
                        for="password"
                        class="form-label"
                    >
                        Password
                    </label>

                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control
                                @error('password') is-invalid @enderror"
                            autocomplete="current-password"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            id="passwordToggle"
                            aria-label="Show password"
                        >
                            Show
                        </button>
                    </div>

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Remember / Forgot password --}}
                <div class="form-options">
                    <label class="remember-label">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                        >

                        <span>Remember me</span>
                    </label>

                    @if(Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            class="forgot-link"
                        >
                            Forgot password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="btn-login"
                    id="loginButton"
                >
                    Login
                </button>
            </form>

            <footer class="footer-text">
                © {{ date('Y') }} EMIS — Authorized Access Only
                <br>
                Developed by DGB IT Team
            </footer>

        </section>

    </main>

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {
                const form =
                    document.getElementById('loginForm');

                const loginButton =
                    document.getElementById('loginButton');

                const passwordInput =
                    document.getElementById('password');

                const passwordToggle =
                    document.getElementById('passwordToggle');

                passwordToggle?.addEventListener(
                    'click',
                    function () {
                        const hidden =
                            passwordInput.type === 'password';

                        passwordInput.type =
                            hidden ? 'text' : 'password';

                        this.textContent =
                            hidden ? 'Hide' : 'Show';

                        this.setAttribute(
                            'aria-label',
                            hidden
                                ? 'Hide password'
                                : 'Show password'
                        );
                    }
                );

                form?.addEventListener(
                    'submit',
                    function () {
                        loginButton.disabled = true;
                        loginButton.textContent =
                            'Signing in...';
                    }
                );
            }
        );
    </script>
</body>
</html>