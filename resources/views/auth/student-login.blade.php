@extends('auth.layout')

@section('title', 'Student Login')
@section('heroTitle', 'Student sign in')
@section('heroCopy', 'Access the student dashboard with a login page styled to match the rest of the app.')

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
    <h2 class="content-title">Student access</h2>
    <p class="content-subtitle">Use your student username or email plus password to sign in.</p>

    <form method="POST" action="{{ route('student.login.attempt') }}">
        @csrf

        <div class="field-grid">
            <div class="field">
                <label for="identifier">Student username or email</label>
                <input id="identifier" type="text" name="identifier" placeholder="student or student@example.com" value="{{ old('identifier') }}" required autofocus>
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
            <button type="submit" class="btn btn-primary">Student sign in</button>
            <a href="{{ route('login') }}" class="btn btn-secondary">User login</a>
        </div>
    </form>

    <div class="footer-links">
        <a href="{{ route('register') }}">User register</a>
        <a href="{{ url('/') }}">Back home</a>
    </div>
@endsection
