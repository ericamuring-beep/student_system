<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        return response()->json(Student::all());
    }

    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->all());
        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['deleted' => true]);
    }

    public function activeStudents()
    {
        $students = Student::active()->get(); // using your scopeActive
        return response()->json($students);
    }

    public function gmailStudents()
    {
        $students = Student::where('email', 'like', '%@gmail.com')->get();
        return response()->json($students);
    }
}