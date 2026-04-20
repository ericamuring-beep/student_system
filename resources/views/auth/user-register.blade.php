@extends('auth.layout')

@section('title', 'User Register')
@section('heroTitle', 'Create a user account')
@section('heroCopy', 'Register with the same design system and land directly in the user dashboard.')

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
    <h2 class="content-title">Register user account</h2>
    <p class="content-subtitle">This form creates a standard user account. Admin accounts are managed separately.</p>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="field-grid">
            <div class="field">
                <label for="name">Full name</label>
                <input id="name" type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Create a password" required>
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Repeat your password" required>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create account</button>
            <a href="{{ route('login') }}" class="btn btn-secondary">Already have an account</a>
        </div>
    </form>

    <div class="footer-links">
        <a href="{{ route('admin.login') }}">Admin login</a>
        <a href="{{ url('/students') }}">Back to students</a>
    </div>
@endsection