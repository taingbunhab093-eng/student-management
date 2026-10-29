<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Sign in or create an account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --board: #17352d;
            --board-deep: #10261f;
            --chalk: #eef3ec;
            --chalk-dim: #b9c9bf;
            --pencil: #f2c230;
            --pencil-hover: #e0b01f;
            --ink: #243b6b;
            --text: #1c2430;
            --muted: #5b6676;
            --line: #d5dae2;
            --field: #f6f7f9;
            --error-bg: #fdecec;
            --error-text: #9b1c1c;
            --ok-bg: #e5f4e8;
            --ok-text: #1d5c2e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Lexend", system-ui, sans-serif;
            color: var(--text);
            background: #ffffff;
            min-height: 100vh;
        }

        .page {
            display: grid;
            grid-template-columns: minmax(320px, 5fr) 6fr;
            min-height: 100vh;
        }

        /* ---------- Left: chalkboard ---------- */
        .board {
            position: relative;
            background-color: var(--board);
            background-image: repeating-linear-gradient(
                to bottom,
                transparent 0,
                transparent 39px,
                rgba(238, 243, 236, 0.07) 39px,
                rgba(238, 243, 236, 0.07) 40px
            );
            color: var(--chalk);
            padding: 56px 56px 56px 88px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .board::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 56px;
            width: 2px;
            background: var(--pencil);
            opacity: 0.85;
        }

        .brand {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .board h1 {
            font-size: clamp(34px, 3.6vw, 52px);
            line-height: 1.15;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .board p {
            font-size: 16px;
            line-height: 1.7;
            color: var(--chalk-dim);
            max-width: 38ch;
        }

        .board-foot {
            font-size: 14px;
            color: var(--chalk-dim);
        }

        /* ---------- Right: forms ---------- */
        .panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
        }

        .panel-inner {
            width: 100%;
            max-width: 420px;
        }

        .tabs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 2px solid var(--line);
            margin-bottom: 32px;
        }

        .tab {
            background: none;
            border: none;
            font: inherit;
            font-size: 16px;
            font-weight: 500;
            color: var(--muted);
            padding: 14px 0;
            cursor: pointer;
            border-bottom: 4px solid transparent;
            margin-bottom: -2px;
            transition: color 0.15s;
        }

        .tab:hover {
            color: var(--text);
        }

        .tab[aria-selected="true"] {
            color: var(--ink);
            font-weight: 600;
            border-bottom-color: var(--pencil);
        }

        .form-title {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-hint {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .alert {
            font-size: 14px;
            line-height: 1.5;
            padding: 12px 14px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: var(--error-bg);
            color: var(--error-text);
            border-left: 4px solid var(--error-text);
        }

        .alert-success {
            background: var(--ok-bg);
            color: var(--ok-text);
            border-left: 4px solid var(--ok-text);
        }

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .field input {
            width: 100%;
            font: inherit;
            font-size: 15px;
            color: var(--text);
            background: var(--field);
            border: 1.5px solid var(--line);
            border-radius: 6px;
            padding: 12px 14px;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }

        .field input::placeholder {
            color: #98a1ae;
        }

        .field input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--ink);
            box-shadow: 0 0 0 3px rgba(36, 59, 107, 0.16);
        }

        .password-wrap {
            position: relative;
        }

        .password-wrap input {
            padding-right: 76px;
        }

        .toggle-pass {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font: inherit;
            font-size: 13px;
            font-weight: 500;
            color: var(--ink);
            padding: 8px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .toggle-pass:hover {
            background: rgba(36, 59, 107, 0.08);
        }

        .help {
            font-size: 13px;
            color: var(--muted);
            margin-top: 6px;
        }

        .submit {
            width: 100%;
            font: inherit;
            font-size: 16px;
            font-weight: 600;
            color: var(--board-deep);
            background: var(--pencil);
            border: none;
            border-radius: 6px;
            padding: 14px;
            margin-top: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .submit:hover {
            background: var(--pencil-hover);
        }

        .switch {
            margin-top: 22px;
            font-size: 14px;
            color: var(--muted);
            text-align: center;
        }

        .link-btn {
            background: none;
            border: none;
            font: inherit;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            text-decoration: underline;
            text-underline-offset: 3px;
            cursor: pointer;
        }

        .form-view[hidden] {
            display: none;
        }

        :focus-visible {
            outline: 3px solid var(--ink);
            outline-offset: 2px;
        }

        .submit:focus-visible {
            outline-color: var(--board-deep);
        }

        /* ---------- Small screens ---------- */
        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
            }

            .board {
                padding: 32px 24px 32px 48px;
                gap: 28px;
            }

            .board::before {
                left: 24px;
            }

            .board h1 {
                font-size: 30px;
            }

            .board-foot {
                display: none;
            }

            .panel {
                padding: 32px 20px 48px;
            }
        }
    </style>
</head>
<body>
    @php
        $showRegister = $errors->has('register_error') || old('form_type') === 'register';
    @endphp

    <div class="page">

        {{-- LEFT: intro --}}
        <aside class="board">
            <div class="brand">Student Portal</div>

            <div>
                <h1>Your student records, in one place.</h1>
                <p>Sign in to view your dashboard and update your details, or create an account to register as a new student.</p>
            </div>

            <div class="board-foot">Need help? Ask your school office.</div>
        </aside>

        {{-- RIGHT: forms --}}
        <main class="panel">
            <div class="panel-inner">

                <div class="tabs" role="tablist" aria-label="Account">
                    <button type="button" class="tab" role="tab" id="tab-login" aria-controls="view-login"
                        aria-selected="{{ $showRegister ? 'false' : 'true' }}">Sign in</button>
                    <button type="button" class="tab" role="tab" id="tab-register" aria-controls="view-register"
                        aria-selected="{{ $showRegister ? 'true' : 'false' }}">Create account</button>
                </div>

                {{-- LOGIN --}}
                <section class="form-view" id="view-login" role="tabpanel" aria-labelledby="tab-login" {{ $showRegister ? 'hidden' : '' }}>
                    <h2 class="form-title">Welcome back</h2>
                    <p class="form-hint">Sign in with the email and password you registered with.</p>

                    @if(session('success'))
                        <div class="alert alert-success" role="status">{{ session('success') }}</div>
                    @endif

                    @if($errors->has('login_error'))
                        <div class="alert alert-error" role="alert">{{ $errors->first('login_error') }}</div>
                    @endif

                    <form action="{{ route('student.login.submit') }}" method="POST">
                        @csrf

                        <div class="field">
                            <label for="login-email">Email address</label>
                            <input type="email" id="login-email" name="email"
                                value="{{ old('form_type') === 'register' ? '' : old('email') }}"
                                placeholder="you@example.com" autocomplete="email" required>
                        </div>

                        <div class="field">
                            <label for="login-password">Password</label>
                            <div class="password-wrap">
                                <input type="password" id="login-password" name="password"
                                    autocomplete="current-password" required>
                                <button type="button" class="toggle-pass" data-target="login-password" aria-label="Show password">Show</button>
                            </div>
                        </div>

                        <button type="submit" class="submit">Sign in</button>
                    </form>

                    <p class="switch">New here? <button type="button" class="link-btn" data-show="register">Create an account</button></p>
                </section>

                {{-- REGISTER --}}
                <section class="form-view" id="view-register" role="tabpanel" aria-labelledby="tab-register" {{ $showRegister ? '' : 'hidden' }}>
                    <h2 class="form-title">Create your account</h2>
                    <p class="form-hint">It takes less than a minute. You can add your academic details after you sign in.</p>

                    @if($errors->has('register_error'))
                        <div class="alert alert-error" role="alert">{{ $errors->first('register_error') }}</div>
                    @endif

                    <form action="{{ route('student.register.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="form_type" value="register">

                        <div class="field">
                            <label for="reg-name">Full name</label>
                            <input type="text" id="reg-name" name="name" value="{{ old('name') }}"
                                placeholder="Your full name" autocomplete="name" required>
                        </div>

                        <div class="field">
                            <label for="reg-email">Email address</label>
                            <input type="email" id="reg-email" name="email"
                                value="{{ old('form_type') === 'register' ? old('email') : '' }}"
                                placeholder="you@example.com" autocomplete="email" required>
                        </div>

                        <div class="field">
                            <label for="reg-password">Password</label>
                            <div class="password-wrap">
                                <input type="password" id="reg-password" name="password"
                                    autocomplete="new-password" minlength="6" required>
                                <button type="button" class="toggle-pass" data-target="reg-password" aria-label="Show password">Show</button>
                            </div>
                            <p class="help">Use at least 6 characters.</p>
                        </div>

                        <button type="submit" class="submit">Create account</button>
                    </form>

                    <p class="switch">Already registered? <button type="button" class="link-btn" data-show="login">Sign in</button></p>
                </section>

            </div>
        </main>
    </div>

    <script>
        (function () {
            const views = {
                login: { tab: document.getElementById('tab-login'), view: document.getElementById('view-login') },
                register: { tab: document.getElementById('tab-register'), view: document.getElementById('view-register') }
            };

            function show(name) {
                Object.keys(views).forEach(function (key) {
                    const active = key === name;
                    views[key].tab.setAttribute('aria-selected', active ? 'true' : 'false');
                    views[key].view.hidden = !active;
                });
            }

            views.login.tab.addEventListener('click', function () { show('login'); });
            views.register.tab.addEventListener('click', function () { show('register'); });

            document.querySelectorAll('[data-show]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    show(btn.getAttribute('data-show'));
                    const first = views[btn.getAttribute('data-show')].view.querySelector('input:not([type=hidden])');
                    if (first) first.focus();
                });
            });

            document.querySelectorAll('.toggle-pass').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const input = document.getElementById(btn.getAttribute('data-target'));
                    const hidden = input.type === 'password';
                    input.type = hidden ? 'text' : 'password';
                    btn.textContent = hidden ? 'Hide' : 'Show';
                    btn.setAttribute('aria-label', hidden ? 'Hide password' : 'Show password');
                });
            });
        })();
    </script>
</body>
</html>