<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// --- Group Guest (Hanya untuk user yang BELUM login) ---
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/forgot-password', [AuthController::class, 'showReset'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Route Logout (Harus bisa diakses setelah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Group Auth & No-Cache (Mencegah Session Persistance & Back History) ---
// Sesuai PBI-005: Manajemen Sesi dan Logout [cite: 57]
Route::middleware(['auth', 'no-cache'])->group(function () {

    // Dashboard Admin (PBI-003: Otorisasi Admin) [cite: 57]
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return '<h1>Dashboard Admin</h1> 
                    <form action="' . route('logout') . '" method="POST"> 
                        ' . csrf_field() . ' 
                        <button type="submit" style="color:red; cursor:pointer;">Logout</button> 
                    </form>';
        });
    });

    // Dashboard Sales (PBI-003: Otorisasi Sales) [cite: 57]
    Route::middleware(['role:sales'])->group(function () {
        Route::get('/sales/dashboard', function () {
            return '<h1>Dashboard Sales</h1> 
                    <form action="' . route('logout') . '" method="POST"> 
                        ' . csrf_field() . ' 
                        <button type="submit" style="color:red; cursor:pointer;">Logout</button> 
                    </form>';
        });
        Route::get('/sales/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/sales/order/store', [OrderController::class, 'store'])->name('order.store');
    });

    // Dashboard Kepala Gudang (PBI-003: Otorisasi Kepala Gudang) [cite: 57]
    Route::middleware(['role:kepala_gudang'])->group(function () {
        Route::get('/gudang/dashboard', function () {
            return '<h1>Dashboard Kepala Gudang</h1> 
                    <form action="' . route('logout') . '" method="POST"> 
                        ' . csrf_field() . ' 
                        <button type="submit" style="color:red; cursor:pointer;">Logout</button> 
                    </form>';
        });
    });
});
