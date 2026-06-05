<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.45rem;
        }

        .content {
            padding: 24px 32px;
        }

        .card-simple,
        .vcard {
            background: transparent;
            border: 0;
            border-radius: 0;
        }

        .card-header-simple,
        .vcard-header {
            padding: 0 0 14px;
            border: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .vcard-body {
            padding: 0;
        }

        .btn-main,
        .btn-val {
            background: #0d6efd;
            color: #fff;
            border: 1px solid #0d6efd;
            border-radius: .375rem;
            padding: .375rem .75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-main:hover,
        .btn-val:hover {
            background: #0b5ed7;
            color: #fff;
        }

        .btn-val-outline,
        .btn-ghost,
        .btn-light-line {
            background: #fff;
            color: #0d6efd;
            border: 1px solid #0d6efd;
            border-radius: .375rem;
            padding: .375rem .75rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-val-outline:hover,
        .btn-ghost:hover,
        .btn-light-line:hover {
            background: #0d6efd;
            color: #fff;
        }

        .btn-val-sm {
            padding: .375rem .75rem;
            font-size: 1rem;
        }

        .vtable {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .vtable th,
        .vtable td {
            padding: .75rem;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .vtable thead th,
        .table thead th {
            background: #212529;
            color: #fff;
            font-weight: 700;
        }

        .val-avatar {
            display: none;
        }

        .badge-status {
            border-radius: .375rem;
            padding: .35em .65em;
            font-size: .875rem;
            font-weight: 700;
        }

        .status-scheduled { background: #d1e7dd; color: #0f5132; }
        .status-rescheduled { background: #fff3cd; color: #664d03; }
        .status-teacher-absent { background: #f8d7da; color: #842029; }
        .status-cancelled { background: #e2e3e5; color: #41464b; }

        .form-label {
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .content {
                padding: 18px 16px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid px-4">
            <a href="{{ route('dashboard') }}" class="navbar-brand">
                <i class="bi bi-calendar2-week me-2"></i>Teacher Schedule
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">Schedules</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">Teachers</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-fill me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="content">
        @yield('content')
    </main>

    <div class="toast-container position-fixed top-0 end-0 p-3">
        @foreach(['success' => 'text-bg-success', 'error' => 'text-bg-danger', 'info' => 'text-bg-info'] as $key => $class)
            @if(session($key))
                <div class="toast {{ $class }} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">{{ session($key) }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.toast').forEach(toastEl => {
            new bootstrap.Toast(toastEl, { delay: 3500 }).show();
        });
    </script>
    @stack('scripts')
</body>
</html>
