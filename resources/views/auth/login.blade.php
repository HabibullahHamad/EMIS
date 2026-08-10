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
            --primary: #2463e9;
            --primary-dark: #123f7c;
            --page-bg: #f2f5f9;
            --input-bg: #edf4ff;
            --text-dark: #111827;
            --text-muted: #586779;
            --border: #c6d2e1;
            --danger: #b91c1c;
            --danger-bg: #fff1f2;
        }
        * {
            box-sizing: border-box;
        }
        html,
        body {
            width: 100%;
            min-height:40%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 70vh;
            padding: 64px 16px 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-dark);
            font-family:
                "Segoe UI",
                Tahoma,
                Arial,
                sans-serif;
            background:
                radial-gradient(
                    circle at top left,
                    rgba(70, 117, 210, 0.08),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #f5f7fa 0%,
                    #eef3f9 100%
                );
        }
        .login-container {
            width: 100%;
            max-width: 430px;
        }
        .login-box {
            position: relative;
            width: 100%;

            padding:
                58px
                28px
                24px;
            background: #ffffff;

            border: 1px solid rgba(15, 23, 42, 0.04);
            border-radius: 17px;

            box-shadow:
                0 24px 50px rgba(30, 58, 95, 0.13),
                0 6px 18px rgba(30, 58, 95, 0.07);
        }

        /* =====================================================
           LOGO
           ===================================================== */

        .logo-wrapper {
            position: absolute;
            top: -37px;
            left: 50%;
            z-index: 5;

            width: 74px;
            height: 74px;

            display: flex;
            align-items: center;
            justify-content: center;

            transform: translateX(-50%);
            background: #ffffff;

            border: 4px solid #edf3fc;
            border-radius: 50%;
            box-shadow:
                0 11px 25px rgba(28, 65, 110, 0.18);
        }

        .logo {
            display: block;
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
        /* =====================================================
           HEADER
           ===================================================== */
        .login-header {
            margin-bottom: 5px;
            text-align: center;
        }
        .login-header h1 {
            margin: 0 0 6px;
            color: var(--primary-dark);
            font-size: 28px;
            font-weight: 750;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }
        .login-header p {
            margin: 0;
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.5;
        }
        /* =====================================================
           ALERTS
           ===================================================== */

        .alert {
            margin-bottom: 17px;
            padding: 10px 12px;
            color: var(--danger);
            background: var(--danger-bg);
            border: 1px solid #fecdd3;
            border-radius: 8px;
            font-size: 13px;
            line-height: 1.5;
        }
        .alert ul {
            margin: 0;
            padding-left: 18px;
        }
        /* =====================================================
           FORM
           ===================================================== */

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;

            color: #050505;

            font-size: 14px;
            font-weight: 700;
        }
        .form-control {
            width: 100%;
            height: 46px;

            padding:
                9px
                9px;

            color: #111827;
            background: var(--input-bg);

            border: 1px solid var(--border);
            border-radius: 9px;

            font-family: inherit;
            font-size: 14px;

            outline: none;

            transition:
                background 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .form-control:hover {
            border-color: #9fb0c5;
        }

        .form-control:focus {
            background: #f2f6ff;
            border-color: #346cf0;

            box-shadow:
                0 0 0 3px rgba(52, 108, 240, 0.17);
        }

        .form-control.is-invalid {
            border-color: #dc2626;
        }

        .invalid-feedback {
            margin-top: 5px;

            color: var(--danger);

            font-size: 12px;
            line-height: 1.4;
        }

        /* =====================================================
           PASSWORD
           ===================================================== */

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .form-control {
            padding-right: 58px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;

            min-width: 45px;
            height: 32px;

            padding: 0 7px;

            transform: translateY(-50%);

            color: #123f7c;
            background: transparent;

            border: 0;
            border-radius: 6px;

            font-family: inherit;
            font-size: 11px;
            font-weight: 700;

            cursor: pointer;
        }

        .password-toggle:hover {
            background: rgba(36, 99, 233, 0.09);
        }

        /* =====================================================
           REMEMBER ME
           ===================================================== */

        .form-options {
            margin:
                1px
                3px
                18px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;
        }

        .remember-label {
            display: inline-flex;
            align-items: center;

            gap: 8px;

            color: #111827;

            font-size: 13px;

            cursor: pointer;
            user-select: none;
        }

        .remember-label input {
            width: 16px;
            height: 16px;
            margin: 0;

            accent-color: var(--primary);

            cursor: pointer;
        }

        /* =====================================================
           BUTTON
           ===================================================== */

        .btn-login {
            width: 100%;
            min-height: 40px;

            padding: 10px 16px;

            color: #ffffff;

            background:
                linear-gradient(
                    90deg,
                    #2b63df 0%,
                    #176cf5 100%
                );

            border: 0;
            border-radius: 9px;

            font-family: inherit;
            font-size: 15px;
            font-weight: 700;

            cursor: pointer;

            box-shadow:
                0 10px 22px rgba(36, 99, 233, 0.24);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                opacity 0.18s ease;
        }

        .btn-login:hover {
            transform: translateY(-1px);

            box-shadow:
                0 13px 27px rgba(36, 99, 233, 0.31);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.70;
            cursor: not-allowed;
            transform: none;
        }

        /* =====================================================
           FOOTER
           ===================================================== */

        .footer-text {
            margin-top: 18px;

            color: #5d7087;

            text-align: center;
            font-size: 9px;
            line-height: 1.7;
        }

        /* =====================================================
           RESPONSIVE
           ===================================================== */

        @media (max-width: 500px) {
            body {
                padding:
                    58px
                    10px
                    18px;
            }

            .login-box {
                padding:
                    55px
                    20px
                    22px;

                border-radius: 15px;
            }

            .logo-wrapper {
                top: -34px;

                width: 120px;
                height: 120px;
            }

            .logo {
                width: 60px;
                height: 60px;
            }

            .login-header h1 {
                font-size: 25px;
            }

            .login-header p {
                font-size: 13px;
            }

            .form-control {
                height: 44px;
            }

            .btn-login {
                min-height: 45px;
            }
        }
    </style>
</head>

<body>

    <main class="login-container">

        <section class="login-box">

            {{-- EMIS Logo --}}
            <div class="logo-wrapper">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="EMIS Logo"
                    class="logo"
                >
            </div>

            {{-- Page heading --}}
            <header class="login-header">
                <h1>MIS</h1>

                <p>
            مدیریتي معلوماتي سیسټم
                </p>
            </header>

            {{-- Session error --}}
            @if(session('error'))
                <div class="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Laravel validation errors --}}
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

                {{-- Username or Email --}}
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
                        placeholder="admin@mail.af"
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

                {{-- Remember me --}}
                <div class="form-options">
                    <label class="remember-label">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            @checked(old('remember'))
                        >

                        <span>
                            Remember me
                        </span>
                    </label>
                </div>

                {{-- Login button --}}


                <button
                    type="submit"
                    class="btn-login"
                    id="loginButton"
                >
                    <span class="login-icon" aria-hidden="true">
                        
                    </span>
                    
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
                const loginForm =
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
                        const passwordIsHidden =
                            passwordInput.type === 'password';

                        passwordInput.type =
                            passwordIsHidden
                                ? 'text'
                                : 'password';

                        passwordToggle.textContent =
                            passwordIsHidden
                                ? 'Hide'
                                : 'Show';

                        passwordToggle.setAttribute(
                            'aria-label',
                            passwordIsHidden
                                ? 'Hide password'
                                : 'Show password'
                        );
                    }
                );

                loginForm?.addEventListener(
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