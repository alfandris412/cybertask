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

// --- AREA KHUSUS ADMIN ---
// Satpam: Harus Login ('auth') DAN Harus Admin ('role:admin')
Route::middleware(['auth', 'role:admin'])->group(function () {
    
    // 1. Dashboard Admin (Sekarang pakai Controller biar angkanya muncul)
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 2. CRUD Projects (Fitur Hari 3)
    // Ini otomatis bikin jalur: index, create, store, edit, update, destroy
    Route::resource('admin/projects', ProjectController::class);
    Route::get('/admin/projects/{project}/members', [ProjectController::class, 'getMembers'])->name('projects.members');

    //task
    Route::resource('admin/tasks', \App\Http\Controllers\TaskController::class);
    

});

// --- AREA KHUSUS KARYAWAN ---
// Satpam: Harus Login ('auth') DAN Harus Karyawan ('role:karyawan')
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    
    // Dashboard Karyawan (Pakai Controller juga)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Nanti Route list tugas karyawan ditaruh sini...
});


// --- AREA UMUM (YANG PENTING LOGIN) ---
// Admin & Karyawan boleh masuk sini untuk edit profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';