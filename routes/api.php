<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'apiIndex']);
Route::post('/students', [StudentController::class, 'apiStore']);
Route::put('/students/{id}', [StudentController::class, 'apiUpdate']);
Route::delete('/students/{id}', [StudentController::class, 'apiDestroy']);
Route::get('/students/active', [StudentController::class, 'activeStudents']);
Route::get('/students/gmail', [StudentController::class, 'gmailStudents']);