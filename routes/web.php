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
Route::middleware(['auth', 'no-cache'])->group(function () {

    // Dashboard Admin (PBI-003 & PBI-010: Perekapan Orderan)
    Route::middleware(['role:admin'])->group(function () {
        // Ubah baris dashboard menjadi seperti ini
        Route::get('/admin/dashboard', [OrderController::class, 'index'])->name('admin.dashboard');
        // Route Konfirmasi PBI-011
        Route::post('/admin/order/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.order.status');
    });

    // Dashboard Sales (PBI-003 & PBI-008: Input Orderan)
    Route::middleware(['role:sales'])->group(function () {
        Route::get('/sales/dashboard', function () {
            return '<h1>Dashboard Sales</h1> 
                    <form action="' . route('logout') . '" method="POST"> 
                        ' . csrf_field() . ' 
                        <button type="submit" style="color:red; cursor:pointer;">Logout</button> 
                    </form>
                    <hr>
                    <a href="' . route('order.create') . '">+ Input Orderan Baru</a>';
        });

        Route::get('/sales/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/sales/order/store', [OrderController::class, 'store'])->name('order.store');
    });

    // Dashboard Kepala Gudang (PBI-003: Otorisasi Kepala Gudang)
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
