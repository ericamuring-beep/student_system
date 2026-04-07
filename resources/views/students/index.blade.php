@extends('students.layout')

@if(session('success'))
	@push('toasts')
		<div class="toast toast-success" data-timeout="4500" role="status" aria-live="polite">
			<div class="toast-body">{{ session('success') }}</div>
			<button type="button" class="toast-close" aria-label="Dismiss notification">x</button>
		</div>
	@endpush
@endif

@if(session('updated_student'))
	@push('toasts')
		<div class="toast toast-warning" data-timeout="5000" role="status" aria-live="polite">
			<div class="toast-body">
				Updated: {{ session('updated_student')->name }} ({{ session('updated_student')->email }})
			</div>
			<button type="button" class="toast-close" aria-label="Dismiss notification">x</button>
		</div>
	@endpush
@endif

@if(session('deleted_student'))
	@push('toasts')
		<div class="toast toast-warning" data-timeout="5000" role="status" aria-live="polite">
			<div class="toast-body">{{ session('deleted_student') }} was deleted.</div>
			<button type="button" class="toast-close" aria-label="Dismiss notification">x</button>
		</div>
	@endpush
@endif

@section('content')
	<h2 class="section-title">All Students</h2>

	<div class="table-wrap">
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Age</th>
					<th>Address</th>
					<th>Email</th>
					<th>Status</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@forelse($students as $student)
					<tr>
						<td>{{ $student->name }}</td>
						<td>{{ $student->age }}</td>
						<td>{{ $student->address }}</td>
						<td>{{ $student->email }}</td>
						<td>
							<span class="status-pill {{ $student->status === 'active' ? 'status-active' : 'status-inactive' }}">
								{{ $student->status }}
							</span>
						</td>
						<td>
							<div class="actions">
								<a href="/students/edit/{{ $student->id }}" class="btn btn-secondary">Edit</a>
								<form action="/students/delete/{{ $student->id }}" method="POST" onsubmit="return confirm('Delete this student?');">
									@csrf
									<button type="submit" class="btn btn-danger">Delete</button>
								</form>
							</div>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="6">No students found yet.</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	<div class="grid-2">
		<section class="mini-card">
			<h3>Active Students</h3>
			<ul class="clean-list">
				@forelse($active as $a)
					<li>{{ $a->name }} - {{ $a->email }}</li>
				@empty
					<li>No active students found.</li>
				@endforelse
			</ul>
		</section>

		<section class="mini-card">
			<h3>Gmail Students (Optional Filter)</h3>
			<ul class="clean-list">
				@forelse($gmail as $g)
					<li>{{ $g->name }} - {{ $g->email }}</li>
				@empty
					<li>No Gmail students found.</li>
				@endforelse
			</ul>
		</section>
	</div>
@endsection