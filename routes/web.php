<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Placeholder untuk Dashboard masing-masing role (PBI-003)
// Melindungi route berdasarkan role (PBI-003)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () { return "Dashboard Admin"; });
});

Route::middleware(['auth', 'role:sales'])->group(function () {
    Route::get('/sales/dashboard', function () { return "Dashboard Sales"; });
});

Route::middleware(['auth', 'role:kepala_gudang'])->group(function () {
    Route::get('/gudang/dashboard', function () { return "Dashboard Kepala Gudang"; });
});
