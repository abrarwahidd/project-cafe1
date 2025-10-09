<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Loop melalui role yang diizinkan untuk route ini
        foreach ($roles as $role) {
            // Jika role user yang sedang login cocok dengan salah satu role yang diizinkan
            if ($request->user()->role == $role) {
                // Lanjutkan request
                return $next($request);
            }
        }

        // Jika tidak ada role yang cocok, kembalikan ke halaman dashboard
        return redirect('/dashboard');
    }
}