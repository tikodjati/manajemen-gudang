<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'], // Validasi role sesuai pilihan di UI
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            // Cek apakah role user di database sama dengan yang dipilih di form
            if (Auth::user()->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'Role yang Anda pilih tidak sesuai dengan akun ini.']);
            }

            $request->session()->regenerate();
            
            // Redirect berdasarkan role (PBI-003)
            return match(Auth::user()->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'sales' => redirect()->intended('/sales/dashboard'),
                'kepala_gudang' => redirect()->intended('/gudang/dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
