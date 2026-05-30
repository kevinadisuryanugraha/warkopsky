<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengelola | Warkop Sky CRM</title>
    
    <!-- Google Fonts: DM Serif Display & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    
    <!-- Main Style Link (Statically linking our app.css) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        :root {
            --color-admin-bg: #070B14;
            --color-admin-card: rgba(16, 24, 48, 0.7);
        }

        body {
            background-color: var(--color-admin-bg);
            color: var(--color-warm-cream);
            font-family: var(--font-body);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Bulb Glow Behind Login Card */
        .login-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(93, 156, 236, 0.1) 0%, rgba(230, 57, 70, 0.05) 50%, transparent 100%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            pointer-events: none;
            filter: blur(40px);
        }

        /* Fine Tactile Noise/Grain Overlay */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.02'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
        }

        .login-container {
            width: 100%;
            max-width: 440px;
            padding: var(--spacing-md);
            position: relative;
            z-index: 10;
            animation: card-appear var(--duration-normal) var(--easing-bounce) forwards;
        }

        @keyframes card-appear {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Glassmorphic Login Card */
        .login-card {
            background: var(--color-admin-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(93, 156, 236, 0.12);
            padding: var(--spacing-lg) var(--spacing-md);
            border-top-left-radius: 32px;
            border-bottom-right-radius: 32px;
            border-top-right-radius: 4px;
            border-bottom-left-radius: 4px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.6);
            position: relative;
            overflow: hidden;
            transition: border-color var(--duration-normal) var(--easing-smooth),
                        box-shadow var(--duration-normal) var(--easing-smooth);
        }

        .login-card:hover {
            border-color: rgba(255, 200, 87, 0.25);
            box-shadow: 0 25px 60px rgba(255, 200, 87, 0.05);
        }

        /* Subtle indicator lighting */
        .login-card::after {
            content: "";
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--color-sky-blue);
            border-bottom-left-radius: 3px;
            border-bottom-right-radius: 3px;
            box-shadow: 0 0 10px var(--color-sky-blue);
        }

        .login-logo {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }

        .login-logo h1 {
            font-family: var(--font-display);
            font-size: 2.2rem;
            color: var(--color-warm-cream);
            margin: 0;
            line-height: 1.1;
        }

        .login-logo span {
            color: var(--color-sky-blue);
            font-size: 0.85rem;
            font-family: var(--font-body);
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            display: block;
            margin-top: 4px;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: var(--spacing-md);
            position: relative;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 6px;
            color: var(--color-muted-text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 2.8rem;
            background: rgba(7, 11, 20, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-top-left-radius: 10px;
            border-bottom-right-radius: 10px;
            color: var(--color-warm-cream);
            font-family: var(--font-body);
            font-size: 0.95rem;
            transition: all var(--duration-fast) var(--easing-smooth);
            outline: none;
        }

        .form-input:focus {
            border-color: var(--color-sky-blue);
            background: rgba(7, 11, 20, 0.95);
            box-shadow: 0 0 15px rgba(93, 156, 236, 0.15);
        }

        /* Input Icons */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-muted-text);
            transition: color var(--duration-fast) var(--easing-smooth);
            pointer-events: none;
        }

        .form-input:focus + .input-icon {
            color: var(--color-sky-blue);
        }

        /* Checkbox Styling */
        .form-remember {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--spacing-md);
            font-size: 0.88rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
            color: var(--color-muted-text);
            transition: color var(--duration-fast) var(--easing-smooth);
        }

        .checkbox-container:hover {
            color: var(--color-warm-cream);
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            height: 18px;
            width: 18px;
            background: rgba(7, 11, 20, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-top-left-radius: 4px;
            border-bottom-right-radius: 4px;
            display: inline-block;
            position: relative;
            transition: all var(--duration-fast) var(--easing-smooth);
        }

        .checkbox-container input:checked ~ .checkmark {
            background: var(--color-sky-blue);
            border-color: var(--color-sky-blue);
            box-shadow: 0 0 10px rgba(93, 156, 236, 0.3);
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }

        .checkbox-container .checkmark:after {
            left: 6px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid var(--color-midnight-bg);
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Submit Button */
        .btn-login {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0.95rem;
            background: var(--color-warkop-red);
            color: var(--color-warm-cream);
            border: none;
            border-top-left-radius: 12px;
            border-bottom-right-radius: 12px;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all var(--duration-fast) var(--easing-bounce);
            box-shadow: 0 6px 20px rgba(230, 57, 70, 0.2);
            outline: none;
            margin-top: var(--spacing-sm);
        }

        .btn-login:hover {
            background: #d62828;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(230, 57, 70, 0.35);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Warnings and Alerts */
        .alert-block {
            margin-bottom: var(--spacing-md);
            padding: 0.9rem 1rem;
            border-top-left-radius: 10px;
            border-bottom-right-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.4;
            display: flex;
            align-items: flex-start;
            gap: 8px;
            animation: alert-slide-down var(--duration-fast) var(--easing-bounce) forwards;
        }

        @keyframes alert-slide-down {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-block--error {
            background: rgba(230, 57, 70, 0.12);
            border: 1px solid var(--color-warkop-red);
            color: var(--color-warm-cream);
        }

        .alert-icon {
            flex-shrink: 0;
            margin-top: 2px;
        }

        .back-to-web {
            text-align: center;
            margin-top: var(--spacing-md);
        }

        .back-to-web a {
            font-size: 0.85rem;
            color: var(--color-muted-text);
            text-decoration: none;
            transition: color var(--duration-fast) var(--easing-smooth);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .back-to-web a:hover {
            color: var(--color-sky-blue);
        }
    </style>
</head>
<body>

    <div class="login-glow"></div>

    <div class="login-container">
        <div class="login-card">
            
            <div class="login-logo">
                <h1>WARKOP SKY</h1>
                <span>Dapur CRM Pengelola</span>
            </div>

            <!-- Validation/Rate Limiting Errors Block -->
            @if ($errors->any())
                <div class="alert-block alert-block--error">
                    <svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="var(--color-warkop-red)" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div style="margin-bottom: 2px;">{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="alert-block" style="background: rgba(93, 156, 236, 0.12); border: 1px solid var(--color-sky-blue); color: var(--color-warm-cream);">
                    <svg class="alert-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="var(--color-sky-blue)" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
                @csrf
                
                <!-- Email Field -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Pengelola</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-input" 
                            placeholder="nama@warkopsky.id" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-input" 
                            placeholder="••••••••" 
                            required
                        >
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="form-remember">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        Ingat sesi saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-login">
                    <span>Masuk ke CRM</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </form>
            
        </div>

        <div class="back-to-web">
            <a href="{{ route('public.home') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Kembali ke Beranda Utama
            </a>
        </div>
    </div>

</body>
</html>
