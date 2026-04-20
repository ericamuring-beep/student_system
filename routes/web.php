<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showUserLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'userLogin'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showUserRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'userRegister'])->name('register.store');

    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.attempt');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('/students', [StudentController::class, 'index'])->name('students.redirect');

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/students', [StudentController::class, 'adminIndex'])->name('admin.students.index');
    });

    Route::prefix('user')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('user.dashboard');
        Route::get('/students', [StudentController::class, 'userIndex'])->name('user.students.index');
    });

    Route::get('/students/view/{student}', [StudentController::class, 'show']);

    Route::middleware('role:admin')->group(function () {
        Route::get('/students/create', [StudentController::class, 'create']);
        Route::post('/students/store', [StudentController::class, 'store']);
        Route::get('/students/edit/{student}', [StudentController::class, 'edit']);
        Route::post('/students/update/{student}', [StudentController::class, 'update']);
        Route::post('/students/delete/{student}', [StudentController::class, 'destroy']);
    });
});

