<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>Login &mdash; System Coffee</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Great+Vibes&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --coffee: #6f4e37;
            --coffee-dark: #5a3d2a;
            --coffee-deep: #4a2f1f;
            --cream: #f7f1e8;
            --cream-light: #fdfbf7;
            --stone: #8a7a6b;
            --gold: #b58e5f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #e9e2d8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .sc-login-card {
            display: flex;
            width: 100%;
            max-width: 1060px;
            min-height: 640px;
            background: var(--cream-light);
            border-radius: 26px;
            overflow: hidden;
            box-shadow: 0 30px 80px rgba(59, 42, 28, 0.28);
            position: relative;
        }

        /* ---------- LEFT PANEL ---------- */
        .sc-left {
            flex: 0 0 44%;
            position: relative;
            background: url("{{ asset('img/login-coffee.jpg') }}") center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 40px;
            overflow: hidden;
        }

        .sc-left::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(42, 26, 15, 0.55) 0%, rgba(42, 26, 15, 0.2) 40%, rgba(42, 26, 15, 0.65) 100%);
            z-index: 1;
        }

        .sc-left > * {
            position: relative;
            z-index: 2;
        }

        .sc-left-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            text-align: center;
        }

        .sc-left-logo {
            color: #e9c9a0;
        }

        .sc-left-name {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 34px;
            color: #fff;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .sc-left-tagline {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.78);
            font-weight: 500;
            margin-top: 2px;
        }

        .sc-left-script {
            text-align: center;
            margin-top: auto;
            margin-bottom: 20px;
        }

        .sc-left-script p {
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 16px;
            line-height: 1.5;
            color: #fff;
            text-shadow: 0 3px 14px rgba(0, 0, 0, 0.4);
            max-width: 240px;
            margin: 0 auto;
        }

        .sc-left-bottom {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
            color: rgba(255, 255, 255, 0.92);
        }

        .sc-left-badges {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .sc-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.4px;
            padding: 7px 13px;
            border-radius: 30px;
            white-space: nowrap;
        }

        .sc-badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #5fbf7a;
            box-shadow: 0 0 8px rgba(95, 191, 122, 0.8);
        }

        /* ---------- RIGHT PANEL ---------- */
        .sc-right {
            flex: 1;
            position: relative;
            padding: 48px 60px;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at 92% 8%, rgba(181, 142, 95, 0.12) 0%, transparent 30%),
                var(--cream-light);
        }

        .sc-top-line {
            display: flex;
            justify-content: flex-end;
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--stone);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .sc-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 30px;
        }

        .sc-header-logo {
            width: 74px;
            height: 74px;
            color: var(--coffee);
            margin-bottom: 8px;
        }

        .sc-header-name {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 32px;
            color: var(--coffee-deep);
            letter-spacing: 0.5px;
        }

        .sc-header-sub {
            font-size: 13px;
            color: var(--stone);
            font-weight: 500;
            margin-top: 2px;
        }

        .sc-welcome {
            font-size: 24px;
            font-weight: 700;
            color: var(--coffee-deep);
            margin-bottom: 2px;
        }

        .sc-welcome-sub {
            font-size: 13px;
            color: var(--stone);
            margin-bottom: 24px;
        }

        .sc-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .sc-field {
            position: relative;
            display: flex;
            align-items: center;
        }

        .sc-field-icon {
            position: absolute;
            left: 18px;
            color: var(--coffee);
            display: flex;
            pointer-events: none;
        }

        .sc-input {
            width: 100%;
            height: 52px;
            border: 1px solid #e4d9c9;
            border-radius: 30px;
            background: #fff;
            padding: 0 46px;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            color: var(--coffee-deep);
            outline: none;
            transition: border-color .25s, box-shadow .25s;
        }

        .sc-input::placeholder {
            color: #b3a796;
        }

        .sc-input:focus {
            border-color: var(--coffee);
            box-shadow: 0 0 0 4px rgba(111, 78, 55, 0.1);
        }

        .sc-input.is-invalid {
            border-color: #c0392b;
        }

        .sc-eye {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--coffee);
            display: flex;
            padding: 4px;
        }

        .sc-error {
            font-size: 12px;
            color: #c0392b;
            margin-top: -8px;
            padding-left: 18px;
        }

        .sc-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -4px;
        }

        .sc-remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--coffee-deep);
            font-weight: 500;
            cursor: pointer;
        }

        .sc-remember input {
            width: 17px;
            height: 17px;
            accent-color: var(--coffee);
            cursor: pointer;
        }

        .sc-forgot {
            font-size: 13px;
            color: var(--coffee);
            font-weight: 500;
            text-decoration: none;
        }

        .sc-forgot:hover {
            text-decoration: underline;
        }

        .sc-login-btn {
            height: 52px;
            width: 100%;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, #7a563d, #5f4230);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: transform .15s, box-shadow .2s;
            box-shadow: 0 10px 24px rgba(95, 66, 48, 0.35);
        }

        .sc-login-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(95, 66, 48, 0.42);
        }

        .sc-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--stone);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 2px 0;
        }

        .sc-divider::before,
        .sc-divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e4d9c9;
        }

        .sc-google-btn {
            height: 50px;
            width: 100%;
            border: 1px solid #e4d9c9;
            border-radius: 30px;
            background: #fff;
            color: var(--coffee-deep);
            font-size: 14px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: background .2s, border-color .2s;
        }

        .sc-google-btn:hover {
            background: #faf5ee;
            border-color: var(--gold);
        }

        .sc-register {
            margin-top: auto;
            text-align: center;
            font-size: 13px;
            color: var(--stone);
            padding-top: 26px;
        }

        .sc-register a {
            color: var(--coffee);
            font-weight: 600;
            text-decoration: underline;
            text-underline-offset: 2px;
        }

        .sc-register a:hover {
            color: var(--coffee-deep);
        }

        .sc-leaf {
            position: absolute;
            top: 26px;
            right: 30px;
            width: 90px;
            opacity: 0.22;
            color: var(--coffee);
            pointer-events: none;
        }

        .sc-beans {
            position: absolute;
            bottom: 24px;
            right: 30px;
            color: var(--coffee);
            opacity: 0.28;
            pointer-events: none;
            display: flex;
            gap: 4px;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 860px) {
            .sc-login-card {
                flex-direction: column;
                max-width: 480px;
                min-height: unset;
            }

            .sc-left {
                flex: none;
                min-height: 220px;
                padding: 28px;
                justify-content: center;
                gap: 16px;
            }

            .sc-left-script p {
                font-size: 15px;
                margin-top: 6px;
            }

            .sc-left-bottom {
                display: none;
            }

            .sc-right {
                padding: 34px 28px;
            }
        }
    </style>
</head>

<body>
    <div class="sc-login-card">
        <!-- LEFT PANEL -->
        <div class="sc-left">
            <div class="sc-left-brand">
                <svg class="sc-left-logo" width="66" height="66" viewBox="0 0 112 112" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M38 20 C30 13, 36 8, 30 1" stroke-width="4.5"/>
                    <path d="M56 22 C48 15, 54 10, 48 3" stroke-width="4.5"/>
                    <path d="M74 20 C66 13, 72 8, 66 1" stroke-width="4.5"/>
                    <path d="M34 34 C36 27, 42 24, 56 24 C70 24, 76 27, 78 34" stroke-width="4.5"/>
                    <path d="M30 34 L82 34" stroke-width="5"/>
                    <path d="M34 38 C36 66, 42 86, 56 86 C70 86, 76 66, 78 38" stroke-width="4.5"/>
                    <path d="M78 46 C92 48, 92 64, 78 66" stroke-width="4.5"/>
                    <path d="M46 60 L66 60" stroke-width="3.5"/>
                    <path d="M50 54 L62 54" stroke-width="3.5"/>
                    <path d="M56 48 L56 68" stroke-width="3.5"/>
                </svg>
                <div class="sc-left-name">System Coffee</div>
                <div class="sc-left-tagline">Good Coffee &bull; Better Days</div>
            </div>

            <div class="sc-left-script">
                <p>Manage your coffee shop in a smarter way</p>
            </div>

            <div class="sc-left-bottom">
                <div class="sc-left-badges">
                    <span class="sc-badge"><span class="sc-badge-dot"></span> Global Status</span>
                    <span class="sc-badge"><span class="sc-badge-dot"></span> Mobile Reservation</span>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="sc-right">
            <svg class="sc-leaf" viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 80 C20 40, 60 20, 90 24" stroke-width="2"/>
                <path d="M30 70 C42 52, 64 40, 84 30" stroke-width="2"/>
                <path d="M28 60 C40 48, 58 40, 74 34" stroke-width="2"/>
                <path d="M26 50 C36 42, 50 36, 62 34" stroke-width="2"/>
            </svg>

            <div class="sc-top-line">Simple &bull; Fast &bull; Secure</div>

            <div class="sc-header">
                <svg class="sc-header-logo" viewBox="0 0 112 112" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M38 20 C30 13, 36 8, 30 1" stroke-width="4.5"/>
                    <path d="M56 22 C48 15, 54 10, 48 3" stroke-width="4.5"/>
                    <path d="M74 20 C66 13, 72 8, 66 1" stroke-width="4.5"/>
                    <path d="M34 34 C36 27, 42 24, 56 24 C70 24, 76 27, 78 34" stroke-width="4.5"/>
                    <path d="M30 34 L82 34" stroke-width="5"/>
                    <path d="M34 38 C36 66, 42 86, 56 86 C70 86, 76 66, 78 38" stroke-width="4.5"/>
                    <path d="M78 46 C92 48, 92 64, 78 66" stroke-width="4.5"/>
                    <path d="M46 60 L66 60" stroke-width="3.5"/>
                    <path d="M50 54 L62 54" stroke-width="3.5"/>
                    <path d="M56 48 L56 68" stroke-width="3.5"/>
                </svg>
                <div class="sc-header-name">System Coffee</div>
                <div class="sc-header-sub">Cafe Management System</div>
            </div>

            <div class="sc-welcome">Welcome Back!</div>
            <div class="sc-welcome-sub">Please login to your account</div>

            <form class="sc-form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="sc-field">
                    <span class="sc-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M4 21 v-1 c0-4 4-6 8-6 s8 2 8 6 v1"></path>
                        </svg>
                    </span>
                    <input id="email" type="email" name="email" class="sc-input @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="Email or Username" tabindex="1" autofocus>
                </div>
                @error('email')
                    <div class="sc-error">{{ $message }}</div>
                @enderror

                <div class="sc-field">
                    <span class="sc-field-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="11" width="16" height="10" rx="2"></rect>
                            <path d="M8 11 V7 a4 4 0 0 1 8 0 v4"></path>
                        </svg>
                    </span>
                    <input id="password" type="password" name="password" class="sc-input @error('password') is-invalid @enderror"
                        placeholder="Password" tabindex="2">
                    <button type="button" class="sc-eye" onclick="togglePassword()" tabindex="-1" aria-label="Show password">
                        <svg id="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12 C4 6 8 4 12 4 C16 4 20 6 23 12 C20 18 16 20 12 20 C8 20 4 18 1 12 Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg id="eye-closed" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                            <path d="M1 12 C4 6 8 4 12 4 C16 4 20 6 23 12"></path>
                            <path d="M4 20 L20 4"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <div class="sc-error">{{ $message }}</div>
                @enderror

                <div class="sc-row">
                    <label class="sc-remember">
                        <input type="checkbox" name="remember" checked>
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="sc-forgot">Forgot Password?</a>
                </div>

                <button type="submit" class="sc-login-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3 h4 a2 2 0 0 1 2 2 v14 a2 2 0 0 1 -2 2 h-4"></path>
                        <path d="M10 17 l5 -5 -5 -5"></path>
                        <path d="M15 12 H3"></path>
                    </svg>
                    Login
                </button>

                <div class="sc-divider">OR</div>

                <button type="button" class="sc-google-btn">
                    <svg width="19" height="19" viewBox="0 0 48 48">
                        <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.3 6.1 29.4 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.6-.4-3.9z"></path>
                        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.3 6.1 29.4 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"></path>
                        <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"></path>
                        <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C36.9 39.2 44 34 44 24c0-1.3-.1-2.6-.4-3.9z"></path>
                    </svg>
                    Login with Google
                </button>
            </form>

            <div class="sc-register">Don't have an account? <a href="{{ route('register') }}">Register</a></div>

            <div class="sc-beans">
                <svg width="20" height="26" viewBox="0 0 20 26" fill="currentColor">
                    <path d="M10 0 C4 3 2 9 4 15 C5 20 8 24 10 26 C13 22 16 16 15 9 C14 4 12 1 10 0 Z"/>
                </svg>
                <svg width="20" height="26" viewBox="0 0 20 26" fill="currentColor" style="transform:rotate(18deg)">
                    <path d="M10 0 C4 3 2 9 4 15 C5 20 8 24 10 26 C13 22 16 16 15 9 C14 4 12 1 10 0 Z"/>
                </svg>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var pw = document.getElementById('password');
            var open = document.getElementById('eye-open');
            var closed = document.getElementById('eye-closed');
            if (pw.type === 'password') {
                pw.type = 'text';
                open.style.display = 'none';
                closed.style.display = 'block';
            } else {
                pw.type = 'password';
                open.style.display = 'block';
                closed.style.display = 'none';
            }
        }
    </script>
</body>

</html>
