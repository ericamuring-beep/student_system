@extends('auth.layout')

@section('title', 'Instructor Login')
@section('heroTitle', 'Instructor sign in')
@section('heroCopy', 'Access the instructor dashboard with a login page styled to match the rest of the app.')

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
    <h2 class="content-title">Instructor access</h2>
    <p class="content-subtitle">Use your instructor username or email plus password to sign in.</p>

    <form method="POST" action="{{ route('instructor.login.attempt') }}">
        @csrf

        <div class="field-grid">
            <div class="field">
                <label for="identifier">Instructor username or email</label>
                <input id="identifier" type="text" name="identifier" placeholder="instructor or instructor@example.com" value="{{ old('identifier') }}" required autofocus>
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
            <button type="submit" class="btn btn-primary">Instructor sign in</button>
            <a href="{{ url('/') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>

    <div class="notice">Demo instructor: instructor@gmail.com or Instructor Account / instructor123</div>
@endsection

