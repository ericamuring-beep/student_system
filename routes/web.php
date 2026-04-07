<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return redirect('/students');
});

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/create', [StudentController::class, 'create']);
Route::post('/students/store', [StudentController::class, 'store']);
Route::get('/students/edit/{student}', [StudentController::class, 'edit']);
Route::post('/students/update/{student}', [StudentController::class, 'update']);
Route::post('/students/delete/{student}', [StudentController::class, 'destroy']);

