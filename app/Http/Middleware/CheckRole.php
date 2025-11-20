<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Configuration\Middleware;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek 1: Apakah user sudah login?
        if (!auth()->check()) {
            return redirect('login');
        }

        // Cek 2: Apakah role user SESUAI dengan pintu yang mau dimasuki?
        if (auth()->user()->role !== $role) {
            abort(403, 'ANDA TIDAK PUNYA AKSES KESINI!');
        }

        return $next($request);
    }
}
