<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Jika belum login
        if (!auth()->check()) {

            return redirect('/login');

        }

        // Jika role tidak sesuai
        if (auth()->user()->role !== $role) {

            abort(
                403,
                'FORBIDDEN ACCESS'
            );

        }

        return $next($request);
    }
}