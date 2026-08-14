<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to access the admin panel.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Unauthorized access.',
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }
            
            // For regular requests, redirect with error message
            return redirect('/home')->with('error', 'You do not have permission to access the admin panel.');
        }

        return $next($request);
    }
}