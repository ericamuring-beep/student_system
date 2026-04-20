@extends('auth.layout')

@section('title', 'Admin Dashboard')
@section('heroTitle', 'Admin dashboard')
@section('heroCopy', 'A quick landing page for administrators with links into the student module and the rest of the app.')

@section('content')
    <h2 class="content-title">Admin overview</h2>
    <p class="content-subtitle">You are signed in with admin access. Use the actions below to manage the student system.</p>

    <div class="hero-grid">
        <div class="mini-card">
            <strong>Manage students</strong>
            <span>Open the admin student page for full CRUD access and record management.</span>
        </div>
        <div class="mini-card">
            <strong>Session controls</strong>
            <span>Sign out when finished or move to the generic dashboard route.</span>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ url('/admin/students') }}" class="btn btn-primary">Open students</a>
        <a href="{{ url('/students/create') }}" class="btn btn-secondary">Add student</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
@endsection