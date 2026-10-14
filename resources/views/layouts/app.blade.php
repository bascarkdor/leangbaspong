<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="University Final Exam Project - Student Management System with Relational Departments">
    <title>{{ $title ?? 'Student Management System' }} | SMS Portal</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Design System CSS -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #0ea5e9;
            --accent: #8b5cf6;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --danger-border: #fecaca;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --success-border: #a7f3d0;
            --warning: #f59e0b;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navigation */
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-main);
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: -0.02em;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.35);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-center-menu {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .nav-tab {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }

        .nav-tab:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-tab.active {
            color: var(--primary);
            background: var(--primary-light);
            font-weight: 700;
        }


        .nav-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-full);
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            font-size: 0.82rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-meta-name {
            font-weight: 600;
            font-size: 0.88rem;
        }

        .user-meta-role {
            font-size: 0.75rem;
            color: var(--text-muted);
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 500;
        }

        /* Buttons & Badges */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #4338ca);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35);
        }

        .btn-secondary {
            background: #ffffff;
            color: var(--text-main);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            background: #f1f5f9;
            border-color: var(--border-hover);
        }

        .btn-danger {
            background: var(--danger);
            color: #ffffff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.82rem;
            border-radius: 6px;
        }

        .btn-icon {
            padding: 6px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-icon:hover {
            color: var(--primary);
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .btn-icon.danger:hover {
            color: var(--danger);
            border-color: var(--danger);
            background: var(--danger-bg);
        }

        /* Container */
        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            flex: 1;
            width: 100%;
        }

        /* Card */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.92rem;
            font-weight: 500;
            animation: fadeIn 0.3s ease;
        }

        .alert-success {
            background-color: var(--success-bg);
            color: #065f46;
            border: 1px solid var(--success-border);
        }

        .alert-danger {
            background-color: var(--danger-bg);
            color: #991b1b;
            border: 1px solid var(--danger-border);
        }

        /* Table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.92rem;
        }

        .data-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 600;
            text-align: left;
            padding: 12px 18px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table td {
            padding: 16px 18px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr {
            transition: var(--transition);
        }

        .data-table tbody tr:hover {
            background-color: #f8faff;
        }

        /* Badges */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: var(--radius-full);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .badge-admin {
            background: #ede9fe;
            color: #6d28d9;
            border: 1px solid #ddd6fe;
        }

        .badge-manager {
            background: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }

        .badge-staff {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-student {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }

        .badge-default {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            color: #334155;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 10px 14px;
            font-size: 0.92rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            background-color: #ffffff;
            color: var(--text-main);
            transition: var(--transition);
            font-family: inherit;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.8rem;
            margin-top: 4px;
            display: block;
        }

        .form-hint {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        /* Footer */
        .footer {
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            background: #ffffff;
            padding: 1.5rem 0;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                height: auto;
                padding: 1rem;
                gap: 1rem;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation Bar -->
    <header class="navbar">
        <div class="nav-container">
            <a href="{{ route('students.index') }}" class="brand-logo">
                <div class="brand-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
                <span>SMS <span style="color: var(--primary); font-weight: 500; font-size: 0.95rem;">Portal</span></span>
            </a>

            @auth
            <div class="nav-center-menu">
                <a href="{{ route('students.index') }}" class="nav-tab {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Students</span>
                </a>

                <a href="{{ route('departments.index') }}" class="nav-tab {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Departments</span>
                </a>
            </div>
            @endauth

            <div class="nav-links">
                @auth
                    <div class="nav-user">
                        <div class="user-avatar-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <span class="user-meta-name">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->isStudent())
                            <span class="user-meta-role" style="background: #fef3c7; color: #b45309; border: 1px solid #fde68a;">Student (Read-Only)</span>
                        @else
                            <span class="user-meta-role" style="background: #ede9fe; color: #6d28d9; border: 1px solid #ddd6fe;">{{ Auth::user()->role->role_name ?? 'Admin' }}</span>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm" title="Log Out of System">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-container">
        <!-- Toast Alerts -->
        @if (session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>University Final Exam Project &bull; Student Management System (Laravel 13 &bull; PHP 8.4)</p>
    </footer>
</body>
</html>
