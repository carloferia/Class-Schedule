@extends('layouts.auth')
@section('title', 'REGISTER')

@section('content')
    <div class="form-title">Create Teacher Account</div>
    <p class="form-subtitle">Register a teacher login for the schedule mockup.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Teacher Name</label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Feria Carlo T."
                   value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="feriacarlot@example.com"
                   value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Min. 8 characters" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control"
                   placeholder="Repeat password" required>
        </div>

        <button type="submit" class="btn-val mb-1">
            Create Account
        </button>

        <div class="auth-switch mt-3">
            Already registered? <a href="{{ route('login') }}">Sign in -></a>
        </div>
    </form>
@endsection
