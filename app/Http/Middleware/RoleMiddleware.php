<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Periksa apakah user sudah login dan role-nya sesuai dengan yang diminta di route
        if (!Auth::check() || Auth::user()->role !== $role) {
            abort(403, 'Akses Ditolak: Halaman ini bukan untuk Anda.');
        }

        return $next($request);
    }
}