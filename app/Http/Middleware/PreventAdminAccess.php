<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventAdminAccess
{
    /**
     * Handle an incoming request.
     * Prevents admin from accessing shop and customer-facing pages.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            if ($request->is('komunitas*')) {
                return $next($request);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Admin tidak diizinkan mengakses halaman toko.',
                ], 403);
            }

            return redirect()->route('dashboard.home')->with('info', 'Admin dialihkan ke Dashboard.');
        }

        return $next($request);
    }
}
