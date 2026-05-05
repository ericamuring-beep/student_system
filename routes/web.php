<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Breeze handles authentication routes such as:
| /login, /register, /forgot-password, /reset-password, and /logout
|
| Those routes are loaded at the bottom using:
| require __DIR__.'/auth.php';
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Breeze provides the authentication routes in `routes/auth.php`.
// We keep a single login page and determine the user's role after login.

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| These routes require the user to be logged in.
|
*/

Route::middleware(['auth'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Main Dashboard Redirect
    |--------------------------------------------------------------------------
    |
    | Determine the dashboard destination by role.
    |
    */

    Route::get('/dashboard', function () {
        $role = request()->user()?->role;

        return match ($role) {
            'admin' => redirect()->route('admin.students.index'),
            'teacher' => redirect()->route('teacher.students.index'),
            'instructor' => redirect()->route('instructor.students.index'),
            'user' => redirect()->route('user.students.index'),
            'student' => redirect()->route('student.dashboard'),
            default => abort(403, 'Unauthorized access.'),
        };
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Student Redirect
    |--------------------------------------------------------------------------
    */

    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.redirect');

    /*
    |--------------------------------------------------------------------------
    | Shared Student Detail Route (View)
    |--------------------------------------------------------------------------
    |
    | Admin/Teacher/User can view individual student records.
    | Students (role=student) are blocked (403) per lab requirement.
    |
    */

    Route::get('/students/view/{student}', [StudentController::class, 'show'])
        ->name('students.show');

    /*
    |--------------------------------------------------------------------------
    | Admin Student CRUD (no /admin prefix)
    |--------------------------------------------------------------------------
    |
    | Keep these URLs consistent with the student module views/tests:
    | /students/create, /students/store, /students/edit/{id}, etc.
    |
    */

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/students/create', [StudentController::class, 'create'])
            ->name('students.create');

        Route::post('/students/store', [StudentController::class, 'store'])
            ->name('students.store');

        Route::get('/students/edit/{student}', [StudentController::class, 'edit'])
            ->name('students.edit');

        Route::post('/students/update/{student}', [StudentController::class, 'update'])
            ->name('students.update');

        Route::post('/students/delete/{student}', [StudentController::class, 'destroy'])
            ->name('students.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    |
    | Only users with role = admin can access these routes.
    |
    */

    Route::prefix('admin')
        ->name('admin.')
        ->middleware(['role:admin'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('auth.admin-dashboard');
            })->name('dashboard');

            Route::get('/students', [StudentController::class, 'adminIndex'])
                ->name('students.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Teacher Routes
    |--------------------------------------------------------------------------
    |
    | Teachers can only VIEW student records (read-only access)
    |
    */

    Route::prefix('teacher')
        ->name('teacher.')
        ->middleware(['role:teacher'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('auth.teacher-dashboard');
            })->name('dashboard');

            Route::get('/students', [StudentController::class, 'teacherIndex'])
                ->name('students.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Instructor Routes
    |--------------------------------------------------------------------------
    |
    | Instructors can only VIEW student records (read-only access)
    |
    */

    Route::prefix('instructor')
        ->name('instructor.')
        ->middleware(['role:instructor'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('auth.instructor-dashboard');
            })->name('dashboard');

            Route::get('/students', [StudentController::class, 'instructorIndex'])
                ->name('students.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    |
    | Students have limited/restricted access
    |
    */

    Route::prefix('student')
        ->name('student.')
        ->middleware(['role:student'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('auth.student-dashboard');
            })->name('dashboard');

            Route::get('/students', [StudentController::class, 'studentIndex'])
                ->name('students.index');
        });

    /*
    |--------------------------------------------------------------------------
    | Normal User Routes (Fallback for registration)
    |--------------------------------------------------------------------------
    */

    Route::prefix('user')
        ->name('user.')
        ->middleware(['role:user'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('auth.user-dashboard');
            })->name('dashboard');

            Route::get('/students', [StudentController::class, 'userIndex'])
                ->name('students.index');
        });
});

/*
|--------------------------------------------------------------------------
| Breeze Authentication Routes
|--------------------------------------------------------------------------
|
| This file is created by Laravel Breeze.
| It contains login, register, logout, password reset, and related routes.
|
*/

require __DIR__.'/auth.php';