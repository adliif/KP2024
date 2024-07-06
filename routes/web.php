<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login',  ['title' => 'Login']);
});
require __DIR__ . '/auth.php';

// Routes Role Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('adminDashboard', [AdminController::class, 'index']);
});

// Routes Role Anggota
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('dashboard', [AnggotaController::class, 'index']);
    Route::get('tanggungan', [AnggotaController::class, 'tanggungan']);
    Route::get('history', [AnggotaController::class, 'history']);
    Route::get('helpdesk', [AnggotaController::class, 'helpdesk']);

    Route::get('/profile', [AnggotaController::class, 'viewUser'])->name('profile.view');
    Route::patch('/profile', [AnggotaController::class, 'updateUser'])->name('profile.update');
    Route::delete('/profile', [AnggotaController::class, 'destroyUser'])->name('profile.destroy');
});