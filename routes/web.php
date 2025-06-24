<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\LessonController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Test route to verify authentication
Route::get('test-auth', function () {
    if (Auth::check()) {
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user()->email,
            'role' => Auth::user()->role,
            'is_admin' => in_array(Auth::user()->role, ['admin', 'teacher'])
        ]);
    }
    return response()->json(['authenticated' => false]);
})->middleware(['auth', 'verified']);

// Public lesson viewing (students can read)
Route::get('lessons', [LessonController::class, 'index'])->middleware(['auth', 'verified'])->name('lessons.index');

// Admin/Teacher only routes
Route::get('lessons/create', [LessonController::class, 'create'])->middleware(['auth', 'verified', 'admin'])->name('lessons.create');
Route::post('lessons', [LessonController::class, 'store'])->middleware(['auth', 'verified', 'admin'])->name('lessons.store');

// PARAMETERIZED ROUTES LAST
Route::get('lessons/{lesson}', [LessonController::class, 'show'])->middleware(['auth', 'verified'])->name('lessons.show');
Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->middleware(['auth', 'verified', 'admin'])->name('lessons.edit');
Route::put('lessons/{lesson}', [LessonController::class, 'update'])->middleware(['auth', 'verified', 'admin'])->name('lessons.update');
Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->middleware(['auth', 'verified', 'admin'])->name('lessons.destroy');

Route::post('/api/lessons/{lesson}/ask', [LessonController::class, 'ask'])->middleware(['auth', 'verified']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

