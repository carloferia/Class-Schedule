<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule // @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --green: #198754;
            --border: #dee2e6;
            --muted: #6c757d;
        }

        body {
            background: #f6f7f9;
            color: #212529;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
        }

        .brand {
            font-weight: 700;
            color: var(--green);
            text-decoration: none;
        }

        .shell {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: calc(100vh - 58px);
        }

        .sidebar {
            background: #fff;
            border-right: 1px solid var(--border);
            padding: 16px;
        }

        .nav-link-simple {
            display: block;
            color: #343a40;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 4px;
        }

        .nav-link-simple:hover,
        .nav-link-simple.active {
            background: #e9f7ef;
            color: var(--green);
        }

        .content {
            padding: 24px;
        }

        .card-simple {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        .card-header-simple {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
        }

        .btn-main {
            background: var(--green);
            color: #fff;
            border: 1px solid var(--green);
            border-radius: 6px;
            padding: 7px 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-main:hover { background: #146c43; color: #fff; }

        .btn-light-line {
            background: #fff;
            color: #343a40;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 7px 10px;
            text-decoration: none;
        }

        .badge-status {
            border-radius: 999px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-scheduled { background: #e9f7ef; color: #146c43; }
        .status-rescheduled { background: #fff3cd; color: #997404; }
        .status-teacher-absent { background: #f8d7da; color: #842029; }
        .status-cancelled { background: #e9ecef; color: #495057; }

        .table th {
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
        }

        .form-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
        }

        @media (max-width: 768px) {
            .shell { grid-template-columns: 1fr; }
            .sidebar {
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }
            .content { padding: 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>
    <header class="topbar">
        <a href="{{ route('dashboard') }}" class="brand">Teacher Schedule</a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
            </form>
        </div>
    </header>

    <div class="shell">
        <aside class="sidebar">
            <a href="{{ route('dashboard') }}" class="nav-link-simple {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('expenses.index') }}" class="nav-link-simple {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                Schedules
            </a>
            <a href="{{ route('users.index') }}" class="nav-link-simple {{ request()->routeIs('users.*') ? 'active' : '' }}">
                Teachers
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link-simple {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                Profile
            </a>
        </aside>

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
