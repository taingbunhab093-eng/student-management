<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StudentController;

// Smart redirect at root
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('student.dashboard');
    }
    return redirect()->route('login');
});

// Guest Routes (Only accessible when NOT logged in)
Route::middleware('guest')->group(function () {
    Route::get('/student/login', [StudentController::class, 'showLoginForm'])->name('login');
    Route::get('/student/register', [StudentController::class, 'showLoginForm'])->name('student.register');

    Route::post('/student/login', [StudentController::class, 'login'])->name('student.login.submit');
    Route::post('/student/register', [StudentController::class, 'register'])->name('student.register.submit');
});

// Authenticated Routes (Must be logged in)
Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::post('/student/store', [StudentController::class, 'storeStudent'])->name('student.store');
    Route::post('/student/logout', [StudentController::class, 'logout'])->name('student.logout');

    Route::get('/student/{id}/edit', [StudentController::class, 'editStudent'])->name('student.edit');
    Route::put('/student/{id}', [StudentController::class, 'updateStudent'])->name('student.update');
    Route::delete('/student/{id}', [StudentController::class, 'deleteStudent'])->name('student.delete');
});