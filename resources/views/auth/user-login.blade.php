@extends('auth.layout')

@section('title', 'User Login')
@section('heroTitle', 'User sign in')
@section('heroCopy', 'Log in to access your user dashboard and continue with the student system.')

@if($errors->any())
    @foreach($errors->all() as $error)
        @push('toasts')
            <div class="toast toast-error" data-timeout="6500" role="alert" aria-live="assertive">
                <div class="toast-body">{{ $error }}</div>
                <button type="button" class="toast-close" aria-label="Dismiss notification">x</button>
            </div>
        @endpush
    @endforeach
@endif

@section('content')
    <h2 class="content-title">Welcome back</h2>
    <p class="content-subtitle">Use your username or email plus password to sign in, or create your own account if needed.</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="field-grid">
            <div class="field">
                <label for="identifier">Username or email</label>
                <input id="identifier" type="text" name="identifier" placeholder="username or name@example.com" value="{{ old('identifier') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter password" required>
            </div>
        </div>

        <label class="checkbox-row" for="remember">
            <input id="remember" type="checkbox" name="remember" value="1">
            <span>Remember me</span>
        </label>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Sign in</button>
            <a href="{{ route('register') }}" class="btn btn-secondary">Create account</a>
        </div>
    </form>

    <div class="footer-links">
        <a href="{{ route('admin.login') }}">Admin login</a>
        <a href="{{ url('/students') }}">Back to students</a>
    </div>

    <div class="notice">Demo user: user@gmail.com or User Account / user123</div>
@endsection