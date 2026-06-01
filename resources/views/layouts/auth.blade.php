<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Schedule // @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f6f7f9;
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
            background: #198754;
            color: #fff;
            border: 1px solid #198754;
            border-radius: 6px;
            padding: 9px 12px;
        }
        .auth-switch {
            text-align: center;
            margin-top: 16px;
            color: #6c757d;
            font-size: 14px;
        }
        .auth-switch a { color: #198754; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
    <div class="auth-card">
        @yield('content')
    </div>
</body>
</html>
