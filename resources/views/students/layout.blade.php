<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        :root {
            --bg-start: #f8fafc;
            --bg-end: #fff7ed;
            --surface: rgba(255, 255, 255, 0.82);
            --surface-soft: #f8fafc;
            --text: #0f172a;
            --muted: #64748b;
            --primary: #0f766e;
            --primary-hover: #0b5f58;
            --accent: #f97316;
            --danger: #b91c1c;
            --border: rgba(148, 163, 184, 0.28);
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.13);
            --radius: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            background: radial-gradient(circle at 10% 10%, #99f6e4 0%, transparent 30%),
                        radial-gradient(circle at 90% 15%, #fdba74 0%, transparent 28%),
                        radial-gradient(circle at 15% 90%, #bfdbfe 0%, transparent 32%),
                        linear-gradient(120deg, var(--bg-start), var(--bg-end));
            min-height: 100vh;
        }

        .container {
            width: min(1100px, 92vw);
            margin: 34px auto;
        }

        .header {
            background: var(--surface);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 20px;
            animation: rise 320ms ease-out;
        }

        .title {
            margin: 0;
            font-size: clamp(1.3rem, 2vw, 1.8rem);
            font-weight: 800;
        }

        .subtitle {
            margin: 8px 0 18px;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .nav {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .logout-form {
            display: inline-flex;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            border-radius: var(--radius);
            padding: 22px;
            animation: rise 360ms ease-out;
            backdrop-filter: blur(12px);
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

        .btn-danger {
            color: var(--danger);
            border-color: #fecdd3;
            background: #fff1f2;
        }

        .btn-danger:hover {
            background: #fee2e2;
        }

        .alert {
            border-radius: 11px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 0.93rem;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-warning {
            background: #fffbeb;
            border: 1px solid #fcd34d;
            color: #92400e;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .section-title {
            margin: 0 0 14px;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .search-panel {
            margin-bottom: 16px;
            padding: 16px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.9);
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: end;
            flex-wrap: wrap;
        }

        .search-field {
            flex: 1 1 280px;
        }

        .search-field label {
            display: block;
            margin-bottom: 6px;
        }

        .search-help {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .search-summary {
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 0.92rem;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #f1f5f9;
            text-align: left;
            font-size: 0.92rem;
        }

        th {
            background: var(--surface-soft);
            font-size: 0.83rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #334155;
        }

        tr:hover td {
            background: #f8fafc;
        }

        .status-pill {
            display: inline-block;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 5px 9px;
            text-transform: capitalize;
        }

        .status-active {
            color: #065f46;
            background: #ccfbf1;
        }

        .status-inactive {
            color: #7f1d1d;
            background: #ffe4e6;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .grid-2 {
            margin-top: 18px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .mini-card {
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px;
            background: rgba(255, 255, 255, 0.92);
        }

        .mini-card h3 {
            margin: 0 0 9px;
            font-size: 0.96rem;
        }

        ul.clean-list {
            margin: 0;
            padding-left: 18px;
        }

        ul.clean-list li {
            margin-bottom: 6px;
            color: #374151;
        }

        form {
            margin: 0;
        }

        .form-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
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

        input,
        select {
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px 11px;
            font-size: 0.95rem;
            width: 100%;
            background: #fff;
            color: var(--text);
            transition: all 180ms ease;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: #2dd4bf;
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.25);
        }

        .form-actions {
            margin-top: 16px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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

        @keyframes rise {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @media (max-width: 760px) {
            .container {
                width: 94vw;
                margin: 18px auto;
            }

            .header,
            .card {
                padding: 16px;
            }

            .search-form {
                align-items: stretch;
            }

            .search-field {
                flex-basis: 100%;
            }

            .grid-2,
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="toast-stack" id="toastStack">
        @stack('toasts')
    </div>

    <div class="container">
        <header class="header">
            <h1 class="title">Student Management System</h1>
            <p class="subtitle">Manage student records quickly with a cleaner and easier interface.</p>
            <nav class="nav">
                <a href="/students" class="btn btn-secondary">Student List</a>
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="/students/create" class="btn btn-primary">Add Student</a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </nav>
        </header>

        <main class="card">
            @yield('content')
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
    @stack('scripts')
</body>
</html>