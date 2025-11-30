<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController; // Panggil Controller Dashboard
use App\Http\Controllers\ProjectController;   // Panggil Controller Project
use App\Http\Controllers\TaskController;
// 1. Halaman Depan (Landing Page) - Bisa diakses siapa saja
Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (ADMIN & KARYAWAN) ---
// Single dashboard route that handles both roles
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// --- AREA KHUSUS ADMIN ---
// Satpam: Harus Login ('auth') DAN Harus Admin ('role:admin')
Route::middleware(['auth', 'role:admin'])->group(function () {

    // 2. CRUD Projects - Akses utama untuk project management
    Route::resource('projects', ProjectController::class);
    Route::get('/projects/{project}/members', [ProjectController::class, 'getMembers'])->name('projects.members');

    // 3. CRUD Tasks - Hanya create, store, edit, update, destroy (show pakai route unified)
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/projects/{project}/tasks/create', [TaskController::class, 'create'])->name('projects.tasks.create');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

});

// --- AREA UMUM (ADMIN & KARYAWAN) ---
// Routes yang bisa diakses oleh both admin dan karyawan
Route::middleware('auth')->group(function () {
    // View Projects & Tasks (keduanya bisa lihat)
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    
    // Progress history untuk task
    Route::get('/tasks/{task}/progress', [TaskController::class, 'progress'])->name('tasks.progress');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Chat & Comments
    Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');

    // Update status & progress report
    Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
});

require __DIR__.'/auth.php';