@extends('students.layout')

@section('content')
	<h2 class="section-title">Student Details</h2>

	<div class="mini-card" style="max-width: 740px;">
		<div class="form-grid">
			<div class="field">
				<label>Name</label>
				<input type="text" value="{{ $student->name }}" readonly>
			</div>

			<div class="field">
				<label>Age</label>
				<input type="text" value="{{ $student->age }}" readonly>
			</div>

			<div class="field field-full">
				<label>Address</label>
				<input type="text" value="{{ $student->address }}" readonly>
			</div>

			<div class="field">
				<label>Email</label>
				<input type="text" value="{{ $student->email }}" readonly>
			</div>

			<div class="field">
				<label>Status</label>
				<input type="text" value="{{ ucfirst($student->status) }}" readonly>
			</div>
		</div>

		<div class="form-actions">
			<a href="/students" class="btn btn-secondary">Back to List</a>
			@if($canManageStudents ?? false)
				<a href="/students/edit/{{ $student->id }}" class="btn btn-primary">Edit Student</a>
			@endif
		</div>
	</div>
@endsection
