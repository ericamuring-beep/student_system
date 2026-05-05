@extends('auth.layout')

@section('title', 'Instructor Dashboard')
@section('heroTitle', 'Instructor dashboard')
@section('heroCopy', 'View student records with read-only access.')

@section('content')
    <h2 class="content-title">Welcome, Instructor</h2>
    <p class="content-subtitle">You can view student records but cannot create, edit, or delete them.</p>

    <div class="form-actions">
        <a href="{{ route('instructor.students.index') }}" class="btn btn-primary">View Students</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
    </div>
@endsection

