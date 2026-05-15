<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // Cek apakah user login
        if (!Auth::check()) {
            abort(403);
        }

        // Cek apakah role user sesuai
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
