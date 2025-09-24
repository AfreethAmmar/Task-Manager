<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// 1) Breeze auth routes
require __DIR__ . '/auth.php';

// 2) Root: guest -> /login, auth -> /tasks
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('tasks.index')
        : redirect()->route('login');
});

// 3) Dashboard: just send to tasks
Route::get('/dashboard', fn () => redirect()->route('tasks.index'))
    ->middleware(['auth'])
    ->name('dashboard');

// 4) Protected routes
Route::middleware('auth')->group(function () {
    Route::resource('tasks', TaskController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
