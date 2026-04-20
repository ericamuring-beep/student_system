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

	<p class="search-help">
		@if(($canManageStudents ?? false))
			Admin access: you can create, edit, and delete student records.
		@else
			User access: you can search students and open their details, but editing is disabled.
		@endif
	</p>

	<div class="search-panel">
		<form class="search-form" onsubmit="return false;" role="search" aria-label="Live student table filter">
			<div class="search-field">
				<label for="q">Search students</label>
				<input id="q" type="search" name="q" value="{{ $search ?? '' }}" placeholder="Search by name, email, address, age, or status">
			</div>
			<div class="search-field" style="max-width: 220px;">
				<label for="statusFilter">Status</label>
				<select id="statusFilter" name="status">
					<option value="">All Status</option>
					<option value="active">Active</option>
					<option value="inactive">Inactive</option>
				</select>
			</div>
			<div class="form-actions" style="margin-top: 0;">
				<button type="button" id="clearSearch" class="btn btn-secondary">Clear</button>
			</div>
		</form>
		<p class="search-help">Tip: type to search and use Status to narrow results instantly.</p>
	</div>

	<div class="stats-grid" aria-label="Student summary">
		<div class="stat-card">
			<h3>Active Students</h3>
			<p>Students currently marked as active.</p>
			<strong>{{ $activeCount ?? 0 }}</strong>
		</div>
		<div class="stat-card">
			<h3>Gmail Students (Optional Filter)</h3>
			<p>Students using a Gmail address.</p>
			<strong>{{ $gmailCount ?? 0 }}</strong>
		</div>
	</div>

	<p class="search-summary" id="searchSummary" @if(empty($search)) style="display: none;" @endif>
		@if(!empty($search))
			Showing results for "{{ $search }}".
		@endif
	</p>

	<div class="table-wrap">
		<table id="studentsTable">
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
			<tbody id="studentsTableBody">
				@forelse($students as $student)
					<tr
						data-search-row
						data-status="{{ strtolower($student->status) }}"
						data-student-name="{{ $student->name }}"
						data-student-age="{{ $student->age }}"
						data-student-address="{{ $student->address }}"
						data-student-email="{{ $student->email }}"
						data-student-state="{{ ucfirst($student->status) }}"
					>
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
								<button type="button" class="btn btn-view js-view-student">View</button>
								@if($canManageStudents ?? false)
									<a href="/students/edit/{{ $student->id }}" class="btn btn-secondary">Edit</a>
									<form action="/students/delete/{{ $student->id }}" method="POST" onsubmit="return confirm('Delete this student?');">
										@csrf
										<button type="submit" class="btn btn-danger">Delete</button>
									</form>
								@endif
							</div>
						</td>
					</tr>
				@empty
					<tr data-empty-server-row>
						<td colspan="6">No students found.</td>
					</tr>
				@endforelse
				<tr id="noSearchResultsRow" style="display: none;">
					<td colspan="6">No students found for this search.</td>
				</tr>
			</tbody>
		</table>
	</div>

	@if(method_exists($students, 'links'))
		<div class="pagination-wrap">
			{{ $students->links() }}
		</div>
	@endif

	<div class="student-modal" id="studentModal" aria-hidden="true">
		<div class="student-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="studentModalTitle">
			<div class="student-modal-header">
				<h3 id="studentModalTitle">Student Details</h3>
				<button type="button" class="student-modal-close" id="closeStudentModal" aria-label="Close details">x</button>
			</div>

			<div class="student-modal-body">
				<div class="form-grid">
					<div class="field">
						<label>Name</label>
						<input type="text" id="modalStudentName" readonly>
					</div>

					<div class="field">
						<label>Age</label>
						<input type="text" id="modalStudentAge" readonly>
					</div>

					<div class="field field-full">
						<label>Address</label>
						<input type="text" id="modalStudentAddress" readonly>
					</div>

					<div class="field">
						<label>Email</label>
						<input type="text" id="modalStudentEmail" readonly>
					</div>

					<div class="field">
						<label>Status</label>
						<input type="text" id="modalStudentStatus" readonly>
					</div>
				</div>
			</div>

			<div class="form-actions" style="margin-top: 16px;">
				<button type="button" class="btn btn-secondary" id="closeStudentModalFooter">Close</button>
			</div>
		</div>
	</div>

@endsection

@push('scripts')
	<style>
		.btn-view {
			color: #0f766e;
			background: #ecfeff;
			border-color: #99f6e4;
		}

		.btn-view:hover {
			background: #ccfbf1;
			border-color: #5eead4;
		}

		.stats-grid {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
			gap: 12px;
			margin: 18px 0 22px;
		}

		.stat-card {
			padding: 16px 18px;
			border-radius: 14px;
			border: 1px solid rgba(148, 163, 184, 0.22);
			background: rgba(248, 250, 252, 0.78);
		}

		.stat-card h3 {
			margin: 0 0 6px;
			font-size: 0.98rem;
		}

		.stat-card p {
			margin: 0;
			color: #64748b;
			font-size: 0.92rem;
		}

		.pagination-wrap {
			margin-top: 18px;
			display: flex;
			justify-content: center;
		}

		.stat-card strong {
			display: block;
			margin-top: 10px;
			font-size: 1.85rem;
			line-height: 1;
			color: #0f172a;
		}

		.student-modal {
			position: fixed;
			inset: 0;
			z-index: 1200;
			display: none;
			align-items: center;
			justify-content: center;
			padding: 18px;
			background: rgba(15, 23, 42, 0.28);
			backdrop-filter: blur(7px);
		}

		.student-modal.is-open {
			display: flex;
		}

		.student-modal-dialog {
			width: min(760px, 94vw);
			background: rgba(255, 255, 255, 0.95);
			border: 1px solid rgba(148, 163, 184, 0.35);
			border-radius: 14px;
			box-shadow: 0 22px 55px rgba(2, 6, 23, 0.25);
			padding: 18px;
		}

		.student-modal-header {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 10px;
		}

		.student-modal-header h3 {
			margin: 0;
			font-size: 1.08rem;
		}

		.student-modal-close {
			border: none;
			background: transparent;
			font-size: 1.2rem;
			line-height: 1;
			cursor: pointer;
			color: #475569;
		}

		.modal-open {
			overflow: hidden;
		}
	</style>

	<script>
		(function () {
			var input = document.getElementById('q');
			var statusFilter = document.getElementById('statusFilter');
			var clearButton = document.getElementById('clearSearch');
			var summary = document.getElementById('searchSummary');
			var rows = Array.prototype.slice.call(document.querySelectorAll('[data-search-row]'));
			var viewButtons = Array.prototype.slice.call(document.querySelectorAll('.js-view-student'));
			var noResultsRow = document.getElementById('noSearchResultsRow');
			var serverEmptyRow = document.querySelector('[data-empty-server-row]');
			var modal = document.getElementById('studentModal');
			var closeModalButton = document.getElementById('closeStudentModal');
			var closeModalFooterButton = document.getElementById('closeStudentModalFooter');
			var modalStudentName = document.getElementById('modalStudentName');
			var modalStudentAge = document.getElementById('modalStudentAge');
			var modalStudentAddress = document.getElementById('modalStudentAddress');
			var modalStudentEmail = document.getElementById('modalStudentEmail');
			var modalStudentStatus = document.getElementById('modalStudentStatus');

			if (!input || !statusFilter || !summary || !noResultsRow) {
				return;
			}

			function normalize(value) {
				return (value || '').toString().trim().toLowerCase();
			}

			function updateTable() {
				var term = normalize(input.value);
				var selectedStatus = normalize(statusFilter.value);
				var visibleCount = 0;

				rows.forEach(function (row) {
					var text = normalize(row.textContent);
					var rowStatus = normalize(row.getAttribute('data-status'));
					var matchText = term === '' || text.indexOf(term) !== -1;
					var matchStatus = selectedStatus === '' || rowStatus === selectedStatus;
					var match = matchText && matchStatus;

					row.style.display = match ? '' : 'none';
					if (match) {
						visibleCount += 1;
					}
				});

				if (serverEmptyRow) {
					serverEmptyRow.style.display = rows.length === 0 ? '' : 'none';
				}

				var showNoResults = rows.length > 0 && visibleCount === 0;
				noResultsRow.style.display = showNoResults ? '' : 'none';

				if (term === '' && selectedStatus === '') {
					summary.style.display = 'none';
					summary.textContent = '';
					return;
				}

				summary.style.display = '';
				var summaryParts = [];
				if (term !== '') {
					summaryParts.push('search "' + input.value.trim() + '"');
				}
				if (selectedStatus !== '') {
					summaryParts.push('status "' + selectedStatus + '"');
				}
				summary.textContent = 'Showing ' + visibleCount + ' result' + (visibleCount === 1 ? '' : 's') + ' for ' + summaryParts.join(' + ') + '.';
			}

			function openModalFromRow(row) {
				if (!modal || !row) {
					return;
				}

				modalStudentName.value = row.getAttribute('data-student-name') || '';
				modalStudentAge.value = row.getAttribute('data-student-age') || '';
				modalStudentAddress.value = row.getAttribute('data-student-address') || '';
				modalStudentEmail.value = row.getAttribute('data-student-email') || '';
				modalStudentStatus.value = row.getAttribute('data-student-state') || '';

				modal.classList.add('is-open');
				modal.setAttribute('aria-hidden', 'false');
				document.body.classList.add('modal-open');
			}

			function closeModal() {
				if (!modal) {
					return;
				}

				modal.classList.remove('is-open');
				modal.setAttribute('aria-hidden', 'true');
				document.body.classList.remove('modal-open');
			}

			input.addEventListener('input', updateTable);
			statusFilter.addEventListener('change', updateTable);

			if (clearButton) {
				clearButton.addEventListener('click', function () {
					input.value = '';
					statusFilter.value = '';
					updateTable();
					input.focus();
				});
			}

			viewButtons.forEach(function (button) {
				button.addEventListener('click', function () {
					var row = button.closest('[data-search-row]');
					openModalFromRow(row);
				});
			});

			if (closeModalButton) {
				closeModalButton.addEventListener('click', closeModal);
			}

			if (closeModalFooterButton) {
				closeModalFooterButton.addEventListener('click', closeModal);
			}

			if (modal) {
				modal.addEventListener('click', function (event) {
					if (event.target === modal) {
						closeModal();
					}
				});
			}

			document.addEventListener('keydown', function (event) {
				if (event.key === 'Escape') {
					closeModal();
				}
			});

			updateTable();
		})();
	</script>
@endpush