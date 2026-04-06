<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use App\Models\User; // Tambahkan ini agar model User terbaca

class AuthController extends Controller
{
    // Tampilan Form Reset Password (PBI-004)
    public function showReset()
    {
        return view('auth.reset-password');
    }

    // Proses Update Password dengan Recovery Phrase (PBI-004)
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'recovery_phrase' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('recovery_phrase', $request->recovery_phrase)
            ->first();

        if (!$user) {
            return back()->withErrors(['recovery_phrase' => 'Email atau Kata Rahasia salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/login')->with('success', 'Password berhasil diubah!');
    }

    // Tampilan Form Login (PBI-002)
    public function showLogin()
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'admin' => redirect('/admin/dashboard'),
                'sales' => redirect('/sales/dashboard'),
                'kepala_gudang' => redirect('/gudang/dashboard'),
            };
        }
        return view('auth.login');
    }

    // Proses Login & Otorisasi Role (PBI-002 & PBI-003)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required'],
        ]);

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            // Cek kesesuaian role (FR-002)
            if (Auth::user()->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['role' => 'Role yang Anda pilih tidak sesuai dengan akun ini.']);
            }

            $request->session()->regenerate();

            // Redirect ke Dashboard sesuai Role (PBI-003)
            return match (Auth::user()->role) {
                'admin' => redirect()->intended('/admin/dashboard'),
                'sales' => redirect()->intended('/sales/dashboard'),
                'kepala_gudang' => redirect()->intended('/gudang/dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // Proses Logout & Manajemen Sesi (PBI-005)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
