<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private function buildCredentials(string $identifier, string $password, ?string $role = null): array
    {
        $field = str_contains($identifier, '@') ? 'email' : 'name';

        $credentials = [
            $field => $identifier,
            'password' => $password,
        ];

        if ($role !== null) {
            $credentials['role'] = $role;
        }

        return $credentials;
    }

    private function syncDemoAccount(string $identifier, string $password, string $email, string $name, string $role): ?User
    {
        if (! in_array($identifier, [$email, $name], true)) {
            return null;
        }

        return User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => $password, 'role' => $role]
        );
    }

    public function showUserLogin()
    {
        return view('auth.user-login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showTeacherLogin()
    {
        return view('auth.teacher-login');
    }

    public function showInstructorLogin()
    {
        return view('auth.instructor-login');
    }

    public function showStudentLogin()
    {
        return view('auth.student-login');
    }

    public function showUserRegister()
    {
        return view('auth.user-register');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($demoUser = $this->syncDemoAccount($credentials['identifier'], $credentials['password'], 'user@gmail.com', 'User Account', 'user')) {
            Auth::login($demoUser);
            $request->session()->regenerate();

            return redirect()->intended('/students');
        }

        if (Auth::attempt($this->buildCredentials($credentials['identifier'], $credentials['password'], 'user'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/students');
        }

        return back()->withErrors([
            'identifier' => 'These credentials do not match a user account.',
        ])->onlyInput('identifier');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($demoAdmin = $this->syncDemoAccount($credentials['identifier'], $credentials['password'], 'admin@gmail.com', 'Admin User', 'admin')) {
            Auth::login($demoAdmin);
            $request->session()->regenerate();

            return redirect()->intended('/students');
        }

        if (Auth::attempt($this->buildCredentials($credentials['identifier'], $credentials['password'], 'admin'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/students');
        }

        return back()->withErrors([
            'identifier' => 'These credentials do not match an admin account.',
        ])->onlyInput('identifier');
    }

    public function teacherLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($demoTeacher = $this->syncDemoAccount($credentials['identifier'], $credentials['password'], 'teacher@gmail.com', 'Teacher Account', 'teacher')) {
            Auth::login($demoTeacher);
            $request->session()->regenerate();

            return redirect()->intended('/teacher/students');
        }

        if (Auth::attempt($this->buildCredentials($credentials['identifier'], $credentials['password'], 'teacher'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/teacher/students');
        }

        return back()->withErrors([
            'identifier' => 'These credentials do not match a teacher account.',
        ])->onlyInput('identifier');
    }

    public function instructorLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($demoInstructor = $this->syncDemoAccount($credentials['identifier'], $credentials['password'], 'instructor@gmail.com', 'Instructor Account', 'instructor')) {
            Auth::login($demoInstructor);
            $request->session()->regenerate();

            return redirect()->intended('/instructor/students');
        }

        if (Auth::attempt($this->buildCredentials($credentials['identifier'], $credentials['password'], 'instructor'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/instructor/students');
        }

        return back()->withErrors([
            'identifier' => 'These credentials do not match an instructor account.',
        ])->onlyInput('identifier');
    }

    public function studentLogin(Request $request)
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($demoStudent = $this->syncDemoAccount($credentials['identifier'], $credentials['password'], 'student@gmail.com', 'Student Account', 'student')) {
            Auth::login($demoStudent);
            $request->session()->regenerate();

            return redirect()->intended('/student/dashboard');
        }

        if (Auth::attempt($this->buildCredentials($credentials['identifier'], $credentials['password'], 'student'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'identifier' => 'These credentials do not match a student account.',
        ])->onlyInput('identifier');
    }

    public function userRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/students')->with('success', 'Account created successfully.');
    }

    public function dashboard(Request $request)
    {
        $userRole = $request->user()?->role;

        return match($userRole) {
            'admin' => redirect()->route('admin.students.index'),
            'teacher' => redirect()->route('teacher.students.index'),
            'instructor' => redirect()->route('instructor.students.index'),
            'student' => redirect()->route('student.dashboard'),
            default => redirect()->route('user.students.index'),
        };
    }

    public function adminDashboard()
    {
        return view('auth.admin-dashboard');
    }

    public function userDashboard()
    {
        return view('auth.user-dashboard');
    }

    public function teacherDashboard()
    {
        return view('auth.teacher-dashboard');
    }

    public function instructorDashboard()
    {
        return view('auth.instructor-dashboard');
    }

    public function studentDashboard()
    {
        return view('auth.student-dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}