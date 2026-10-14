<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Student Management System
|--------------------------------------------------------------------------
*/

// Redirect root to students list
Route::get('/', function () {
    return redirect()->route('students.index');
});

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Management Routes (Restricted: Administrators Only)
    // Students cannot create, edit, or delete
    Route::middleware('can-manage')->group(function () {
        Route::resource('students', StudentController::class)->except(['index', 'show']);
        Route::resource('departments', DepartmentController::class)->except(['index', 'show']);
        Route::resource('users', UserController::class);
    });

    // Read-Only Routes (Accessible by All Roles, including Student)
    Route::resource('students', StudentController::class)->only(['index', 'show']);
    Route::resource('departments', DepartmentController::class)->only(['index', 'show']);
});
