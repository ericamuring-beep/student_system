@extends('auth.layout')

@section('title', 'Teacher Dashboard')
@section('heroTitle', 'Teacher dashboard')
@section('heroCopy', 'A quick landing page for teachers with view-only access to the student module.')

@section('content')
    <h2 class="content-title">Teacher overview</h2>
    <p class="content-subtitle">You are signed in with teacher access. You can view student records (read-only).</p>

    <div class="hero-grid">
        <div class="mini-card">
            <strong>View students</strong>
            <span>Open the teacher student page for read-only access to all student records.</span>
        </div>
        <div class="mini-card">
            <strong>Session controls</strong>
            <span>Sign out when finished or return to view student records.</span>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ url('/teacher/students') }}" class="btn btn-primary">View students</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
@endsection
