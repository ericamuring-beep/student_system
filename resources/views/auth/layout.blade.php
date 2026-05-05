<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication') - Student Management System</title>
    <style>
        :root {
            --bg-start: #f8fafc;
            --bg-end: #fff7ed;
            --surface: rgba(255, 255, 255, 0.84);
            --text: #0f172a;
            --muted: #64748b;
            --primary: #0f766e;
            --primary-hover: #0b5f58;
            --accent: #f97316;
            --danger: #b91c1c;
            --border: rgba(148, 163, 184, 0.28);
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.13);
            --radius: 18px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            background:
                radial-gradient(circle at 10% 10%, #99f6e4 0%, transparent 30%),
                radial-gradient(circle at 90% 15%, #fdba74 0%, transparent 28%),
                radial-gradient(circle at 15% 90%, #bfdbfe 0%, transparent 32%),
                linear-gradient(120deg, var(--bg-start), var(--bg-end));
            min-height: 100vh;
        }

        .page {
            width: min(1120px, 92vw);
            margin: 28px auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            padding: 18px 20px;
            margin-bottom: 18px;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .brand-subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 11px;
            border: 1px solid transparent;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.92rem;
            cursor: pointer;
            transition: all 200ms ease;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), #0ea5a4);
            box-shadow: 0 8px 20px rgba(15, 118, 110, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-hover), #0f766e);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            border-color: var(--border);
            color: var(--text);
        }

        .btn-secondary:hover {
            background: #ffffff;
            border-color: #cbd5e1;
        }

        .shell {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 18px;
            align-items: stretch;
        }

        .panel {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            padding: 24px;
        }

        .hero {
            position: relative;
            overflow: hidden;
            min-height: 100%;
        }

        .hero::before,
        .hero::after {
            content: '';
            position: absolute;
            border-radius: 999px;
            filter: blur(10px);
            opacity: 0.9;
            pointer-events: none;
        }

        .hero::before {
            width: 180px;
            height: 180px;
            background: rgba(15, 118, 110, 0.14);
            top: -48px;
            right: -36px;
        }

        .hero::after {
            width: 140px;
            height: 140px;
            background: rgba(249, 115, 22, 0.16);
            bottom: -36px;
            left: -28px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(15, 118, 110, 0.1);
            color: var(--primary-hover);
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
        }

        .hero h1 {
            margin: 14px 0 10px;
            font-size: clamp(1.8rem, 3vw, 3rem);
            line-height: 1.06;
            letter-spacing: -0.04em;
        }

        .hero p {
            margin: 0;
            color: var(--muted);
            font-size: 0.98rem;
            line-height: 1.65;
            max-width: 56ch;
        }

        .hero-grid {
            margin-top: 22px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .mini-card {
            border: 1px solid var(--border);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.7);
            padding: 14px;
        }

        .mini-card strong {
            display: block;
            margin-bottom: 6px;
            font-size: 0.95rem;
        }

        .mini-card span {
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.45;
        }

        .content-title {
            margin: 0 0 10px;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .content-subtitle {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 0.94rem;
            line-height: 1.6;
        }

        .field-grid {
            display: grid;
            gap: 12px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #374151;
        }

        input {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 11px;
            font-size: 0.95rem;
            width: 100%;
            background: #fff;
            color: var(--text);
            transition: all 180ms ease;
        }

        input:focus {
            outline: none;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.25);
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .checkbox-row input {
            width: 16px;
            height: 16px;
            margin: 0;
            box-shadow: none;
        }

        .form-actions {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .notice {
            margin-top: 16px;
            padding: 13px 14px;
            border-radius: 12px;
            border: 1px solid rgba(15, 118, 110, 0.16);
            background: rgba(236, 253, 245, 0.9);
            color: #065f46;
            font-size: 0.92rem;
        }

        .toast-stack {
            position: fixed;
            top: 18px;
            right: 18px;
            z-index: 1100;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: min(360px, calc(100vw - 24px));
        }

        .toast {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            border-radius: 12px;
            border: 1px solid transparent;
            box-shadow: var(--shadow);
            background: #fff;
            padding: 11px 12px;
            animation: toastIn 220ms ease-out;
            backdrop-filter: blur(8px);
        }

        .toast-body {
            flex: 1;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #6b7280;
            cursor: pointer;
            font-size: 1rem;
            line-height: 1;
            padding: 2px;
        }

        .toast-success {
            border-color: #a7f3d0;
            background: #ecfdf5;
            color: #065f46;
            border-left: 4px solid #059669;
        }

        .toast-warning {
            border-color: #fcd34d;
            background: #fffbeb;
            color: #92400e;
            border-left: 4px solid var(--accent);
        }

        .toast-error {
            border-color: #fecaca;
            background: #fef2f2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .footer-links {
            margin-top: 16px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 0.92rem;
        }

        .footer-links a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 900px) {
            .shell {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .page {
                width: 94vw;
                margin: 16px auto;
            }

            .panel,
            .topbar {
                padding: 16px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="toast-stack" id="toastStack">
        @stack('toasts')
    </div>

    <div class="page">
        <header class="topbar">
            <div class="brand">
                <h1 class="brand-title">Student Management System</h1>
                <p class="brand-subtitle">Role-based access for admin, teacher, and instructor accounts.</p>
            </div>

            <nav class="nav">
                @auth
                    <a href="{{ url('/students') }}" class="btn btn-secondary">Students</a>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">User Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    <a href="{{ route('admin.login') }}" class="btn btn-secondary">Admin Login</a>
                    <a href="{{ route('teacher.login') }}" class="btn btn-secondary">Teacher Login</a>
                    <a href="{{ route('instructor.login') }}" class="btn btn-secondary">Instructor Login</a>
                @endauth
            </nav>
        </header>

        <main class="shell">
            <section class="panel hero">
                <span class="eyebrow">Secure access</span>
                <h1>@yield('heroTitle', 'A cleaner gateway into the system')</h1>
                <p>@yield('heroCopy', 'Use the same visual language as the student module, with a polished sign-in and dashboard experience for each role.')</p>

                <div class="hero-grid">
                    <div class="mini-card">
                        <strong>Admin workspace</strong>
                        <span>Manage records, review activity, and move between dashboards without leaving the app style.</span>
                    </div>
                    <div class="mini-card">
                        <strong>User workspace</strong>
                        <span>Sign in, register, and land in a focused dashboard built with the same layout rhythm.</span>
                    </div>
                </div>
            </section>

            <section class="panel">
                @yield('content')
            </section>
        </main>
    </div>

    <script>
        (function () {
            var toasts = document.querySelectorAll('.toast');

            function removeToast(toast) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-6px)';
                toast.style.transition = 'all 180ms ease';
                setTimeout(function () {
                    toast.remove();
                }, 180);
            }

            toasts.forEach(function (toast) {
                var timeout = parseInt(toast.getAttribute('data-timeout') || '4500', 10);
                var closeBtn = toast.querySelector('.toast-close');

                if (closeBtn) {
                    closeBtn.addEventListener('click', function () {
                        removeToast(toast);
                    });
                }

                setTimeout(function () {
                    removeToast(toast);
                }, timeout);
            });
        })();
    </script>
</body>
</html>