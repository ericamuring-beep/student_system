@extends('auth.layout')

@section('title', 'User Dashboard')
@section('heroTitle', 'User dashboard')
@section('heroCopy', 'A simple dashboard for standard users, styled to match the rest of the application.')

@if(session('success'))
    @push('toasts')
        <div class="toast toast-success" data-timeout="4500" role="status" aria-live="polite">
            <div class="toast-body">{{ session('success') }}</div>
            <button type="button" class="toast-close" aria-label="Dismiss notification">x</button>
        </div>
    @endpush
@endif

@section('content')
    <h2 class="content-title">Welcome</h2>
    <p class="content-subtitle">Your account is active and ready to use. You can view the limited student page or continue to your own workspace.</p>

    <div class="hero-grid">
        <div class="mini-card">
            <strong>Browse students</strong>
            <span>Open the read-only student page for search and view access.</span>
        </div>
        <div class="mini-card">
            <strong>Account actions</strong>
            <span>Switch back to login screens or log out from the current session.</span>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ url('/user/students') }}" class="btn btn-primary">Open students</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
@endsection