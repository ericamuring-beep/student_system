<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        $active = Student::active()->latest()->get();
        $gmail = Student::gmail()->latest()->get();

        return view('students.index', compact('students', 'active', 'gmail'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
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