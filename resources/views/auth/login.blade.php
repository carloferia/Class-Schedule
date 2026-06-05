@extends('layouts.auth')
@section('title', 'LOGIN')

@section('content')
    <div class="form-title">Teacher Login</div>
    <p class="form-subtitle">View and update your class schedules.</p>

    @if($errors->any())
    <div class="alert alert-danger py-2">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Login failed - check your credentials.
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="feriacarlot@example.com"
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control"
                   placeholder="password" required>
        </div>

        <div class="mb-4 d-flex align-items-center gap-2">
            <input type="checkbox" class="form-check-input m-0" id="remember" name="remember"
                   style="width:14px;height:14px;">
            <label for="remember" class="small text-muted">
                Keep me logged in
            </label>
        </div>

        <button type="submit" class="btn-val mb-1">
            Sign In
        </button>

        <div class="auth-switch mt-3">
            No account yet? <a href="{{ route('register') }}">Register here -></a>
        </div>
    </form>
@endsection
