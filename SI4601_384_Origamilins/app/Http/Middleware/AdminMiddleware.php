<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Periksa apakah user adalah admin
        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
