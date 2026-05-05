<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    private function buildStudentListData(Request $request): array
    {
        $search = trim((string) $request->query('q', ''));
        $status = trim((string) $request->query('status', ''));

        $overviewQuery = Student::query();
        $activeCount = (clone $overviewQuery)->where('status', 'active')->limit(100000)->count();
        $inactiveCount = (clone $overviewQuery)->where('status', 'inactive')->limit(100000)->count();
        $totalCount = (clone $overviewQuery)->limit(100000)->count();

        $baseQuery = $this->applySearch(Student::query(), $search);
        $baseQuery = $this->applyStatusFilter($baseQuery, $status);

        return [
            'students' => (clone $baseQuery)->orderByDesc('id')->paginate(25)->withQueryString(),
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'totalCount' => $totalCount,
            'search' => $search,
            'status' => $status,
        ];
    }

    private function applySearch(Builder $query, string $search): Builder
    {
        if ($search === '') {
            return $query;
        }

        return $query->where(function ($searchQuery) use ($search) {
            $searchQuery->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
                ->orWhere('age', 'like', '%' . $search . '%');
        });
    }

    private function applyStatusFilter(Builder $query, string $status): Builder
    {
        $status = strtolower(trim($status));
        if (! in_array($status, ['active', 'inactive'], true)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user?->role) {
            'admin' => redirect()->route('admin.students.index'),
            'teacher' => redirect()->route('teacher.students.index'),
            'instructor' => redirect()->route('instructor.students.index'),
            'user' => redirect()->route('user.students.index'),
            'student' => redirect()->route('student.students.index'),
            default => abort(403, 'Unauthorized access.'),
        };
    }

    public function adminIndex(Request $request)
    {
        return view('students.index', array_merge($this->buildStudentListData($request), [
            'canManageStudents' => true,
        ]));
    }

    public function userIndex(Request $request)
    {
        return view('students.index', array_merge($this->buildStudentListData($request), [
            'canManageStudents' => false,
        ]));
    }

    public function teacherIndex(Request $request)
    {
        // Teachers can view but not manage
        return view('students.index', array_merge($this->buildStudentListData($request), [
            'canManageStudents' => false,
            'isTeacher' => true,
        ]));
    }

    public function instructorIndex(Request $request)
    {
        // Instructors can view but not manage
        return view('students.index', array_merge($this->buildStudentListData($request), [
            'canManageStudents' => false,
            'isInstructor' => true,
        ]));
    }

    public function studentIndex(Request $request)
    {
        // Students: restricted access = view-only
        return view('students.index', array_merge($this->buildStudentListData($request), [
            'canManageStudents' => false,
            'isStudent' => true,
        ]));
    }

    public function create()
    {
        return view('students.create');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function show(Request $request, Student $student)
    {
        return view('students.show', [
            'student' => $student,
            'canManageStudents' => $request->user()?->role === 'admin',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Student::create($validated);

        return redirect('/students')->with('success', 'Student record added successfully.');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $student->update($validated);

        return redirect('/students')->with('updated_student', $student->fresh());
    }

    public function destroy(Student $student)
    {
        $deletedStudent = $student->name . ' (' . $student->email . ')';
        $student->delete();

        return redirect('/students')->with('deleted_student', $deletedStudent);
    }

    public function activeStudents()
    {
        $students = Student::active()->get();
        return response()->json($students);
    }

    public function gmailStudents()
    {
        $students = Student::gmail()->get();
        return response()->json($students);
    }

    public function apiIndex()
    {
        return response()->json(Student::all());
    }

    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:students,email'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $student = Student::create($validated);
        return response()->json($student, 201);
    }

    public function apiUpdate(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:1', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('students', 'email')->ignore($student->id)],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $student->update($validated);
        return response()->json($student);
    }

    public function apiDestroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['deleted' => true]);
    }
}