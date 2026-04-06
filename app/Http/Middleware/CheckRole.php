<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login dan apakah rolenya ada dalam daftar yang diizinkan
        if (Auth::check() && in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar ke halaman login dengan pesan error
        return redirect('/login')->withErrors(['access' => 'Anda tidak memiliki hak akses ke halaman tersebut.']);
    }
}
