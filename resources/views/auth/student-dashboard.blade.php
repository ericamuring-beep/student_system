@extends('auth.layout')

@section('title', 'Student Dashboard')
@section('heroTitle', 'Student dashboard')
@section('heroCopy', 'A quick landing page for students with limited access to the system.')

@section('content')
    <h2 class="content-title">Student overview</h2>
    <p class="content-subtitle">You are signed in with student access. Your access is limited for security purposes.</p>

    <div class="hero-grid">
        <div class="mini-card">
            <strong>Limited access</strong>
            <span>Student accounts have restricted access to the system. Contact an administrator for more information.</span>
        </div>
        <div class="mini-card">
            <strong>Session controls</strong>
            <span>Sign out when finished with your session.</span>
        </div>
    </div>

    <div class="form-actions">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
@endsection
