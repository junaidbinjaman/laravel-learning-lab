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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if the user is logged in
        if (!Auth::check()) {
            return response()->json([
                'status' => 'fail',
                'message' => 'unauthorized access'
            ], 403);
        }

        // Allow access based on the role
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return response()->json([
            'status' => 'fail',
            'message' => 'You are not allowed to perform this operation'
        ], 403);
    }
}
