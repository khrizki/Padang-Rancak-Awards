<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management Routes (Admin only)
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Wilayah Management Routes (Admin only)
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
        Route::get('/wilayah/kelurahans', [WilayahController::class, 'getKelurahans'])->name('wilayah.kelurahans');
        Route::get('/wilayah/rws', [WilayahController::class, 'getRWs'])->name('wilayah.rws');
        Route::put('/wilayah/{rt}/status', [WilayahController::class, 'updateStatus'])->name('wilayah.updateStatus');
    });
});

require __DIR__.'/auth.php';
