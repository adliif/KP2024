<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\RegisteredUserController;

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('auth.login',  ['title' => 'Login']);
});

// Routes Role Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('adminDashboard', [AdminController::class, 'index']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);    
    Route::get('dataAnggota', [AdminController::class, 'dataAnggota'])->name('dataAnggota');
    Route::get('dataPinjaman', [AdminController::class, 'dataPinjaman']);
    Route::get('dataTanggungan', [AdminController::class, 'dataTanggungan']);
    Route::get('dataSimpananPokok', [AdminController::class, 'dataSimpananPokok']);

    Route::get('/profileAdmin', [AdminController::class, 'viewUser'])->name('profile.view');
    Route::patch('/profileAdmin', [AdminController::class, 'updateUser'])->name('profile.update');
    Route::delete('/profileAdmin', [AdminController::class, 'destroyUser'])->name('profile.destroy');
});

// Routes Role Anggota
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('dashboard', [AnggotaController::class, 'index'])->name('dashboard');
    Route::get('tanggungan', [AnggotaController::class, 'tanggungan']);
    Route::get('history', [AnggotaController::class, 'history']);
    Route::get('helpdesk', [AnggotaController::class, 'helpdesk']);

    Route::get('/profile', [AnggotaController::class, 'viewUser'])->name('profile.view');
    Route::patch('/profile', [AnggotaController::class, 'updateUser'])->name('profile.update');
    Route::delete('/profile', [AnggotaController::class, 'destroyUser'])->name('profile.destroy');
});