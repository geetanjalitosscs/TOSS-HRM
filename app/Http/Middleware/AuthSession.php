<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session exists and is valid
        $session = $request->session();
        
        // If session is not started or auth_user doesn't exist, redirect to login
        if (!$session->has('auth_user')) {
            // Clear any stale session data
            $session->invalidate();
            $session->regenerateToken();
            
            return redirect()->route('login')->with('session_expired', 'Your session has expired. Please login again.');
        }

        return $next($request);
    }
}
