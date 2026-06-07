<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DailyCheckinController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'employee'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employee features
    Route::middleware([\App\Http\Middleware\EnsureEmployee::class])->group(function () {
        Route::prefix('checkins')->name('checkins.')->group(function () {
            Route::get('/', [DailyCheckinController::class, 'index'])->name('index');
            Route::get('/create', [DailyCheckinController::class, 'create'])->name('create');
            Route::post('/', [DailyCheckinController::class, 'store'])->name('store');
            Route::get('/{checkin}', [DailyCheckinController::class, 'show'])->name('show');
        });

        // Leaderboards
        Route::prefix('leaderboards')->name('leaderboards.')->group(function () {
            Route::get('/individual', [LeaderboardController::class, 'individual'])->name('individual');
            Route::get('/department', [LeaderboardController::class, 'department'])->name('department');
        });

        // Employee Events
        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [\App\Http\Controllers\EmployeeEventController::class, 'index'])->name('index');
            Route::get('/my-events', [\App\Http\Controllers\EmployeeEventController::class, 'myEvents'])->name('my-events');
            Route::get('/{event}', [\App\Http\Controllers\EmployeeEventController::class, 'show'])->name('show');
            Route::post('/{event}/join', [\App\Http\Controllers\EmployeeEventController::class, 'join'])->name('join');
        });
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', EmployeeController::class);
    
    // Event Management
    Route::resource('events', EventController::class);
    Route::post('/registrations/{registration}/attendance', [EventController::class, 'markAttendance'])->name('events.attendance');
});

require __DIR__.'/auth.php';
