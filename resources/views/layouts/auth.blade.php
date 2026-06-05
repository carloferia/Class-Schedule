<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule // @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .auth-card {
            width: min(420px, calc(100% - 24px));
            background: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 24px;
        }
        .form-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .form-subtitle {
            color: #6c757d;
            margin-bottom: 20px;
        }
        .btn-val {
            width: 100%;
            background: #0d6efd;
            color: #fff;
            border: 1px solid #0d6efd;
            border-radius: 6px;
            padding: 9px 12px;
        }
        .auth-switch {
            text-align: center;
            margin-top: 16px;
            color: #6c757d;
            font-size: 14px;
        }
        .auth-switch a { color: #0d6efd; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
    <div class="auth-card">
        @yield('content')
    </div>

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
</body>
</html>
