<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes (Global)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/tracker', function () {
        return view('tracker');
    })->name('tracker');

    Route::post('/api/location/sync', [App\Http\Controllers\Api\LocationController::class, 'sync']);
});

// Admin Protected Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/api/admin/black_spots', [AdminController::class, 'getBlackSpots']);
    Route::post('/api/admin/black_spots', [AdminController::class, 'storeBlackSpot']);
    Route::delete('/api/admin/black_spots/{id}', [AdminController::class, 'deleteBlackSpot']);
});
