@extends('students.layout')

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
	<h2 class="section-title">Add Student</h2>

	<form method="POST" action="/students/store">
		@csrf

		<div class="form-grid">
			<div class="field">
				<label for="name">Name</label>
				<input id="name" type="text" name="name" placeholder="Enter full name" value="{{ old('name') }}">
			</div>

			<div class="field">
				<label for="age">Age</label>
				<input id="age" type="number" name="age" placeholder="Enter age" value="{{ old('age') }}">
			</div>

			<div class="field field-full">
				<label for="address">Address</label>
				<input id="address" type="text" name="address" placeholder="Street, city, state" value="{{ old('address') }}">
			</div>

			<div class="field">
				<label for="email">Email</label>
				<input id="email" type="email" name="email" placeholder="name@example.com" value="{{ old('email') }}">
			</div>

			<div class="field">
				<label for="status">Status</label>
				<select id="status" name="status">
					<option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>active</option>
					<option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>inactive</option>
				</select>
			</div>
		</div>

		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Save Student</button>
			<a href="/students" class="btn btn-secondary">Cancel</a>
		</div>
	</form>
@endsection