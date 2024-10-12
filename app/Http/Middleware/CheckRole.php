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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles){
        // Check the role based on guard
        if (!auth($guard)->check()) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses.');
        }

        $userRole = auth($guard)->user()->role;

        // Misal, cek role yang diizinkan dari route
        if (!in_array($userRole, $roles)) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
