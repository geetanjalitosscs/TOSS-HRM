<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        // Load current user with page permissions
        $authUser = $session->get('auth_user');
        $userId = $authUser['id'] ?? null;
        $pagePermissions = [];
        $isMainUser = false;

        if ($userId) {
            $user = DB::table('users')
                ->where('id', $userId)
                ->select('is_main_user', 'page_permissions')
                ->first();

            if ($user) {
                $isMainUser = (bool) ($user->is_main_user ?? false);

                $rawPerms = $user->page_permissions ?? null;
                if (!$isMainUser) {
                    if (is_string($rawPerms) && $rawPerms !== '') {
                        $decoded = json_decode($rawPerms, true);
                        if (is_array($decoded)) {
                            $pagePermissions = $decoded;
                        }
                    } elseif (is_array($rawPerms)) {
                        $pagePermissions = $rawPerms;
                    }
                }
            }
        }

        // Share with all views for sidebar
        view()->share('pagePermissions', $pagePermissions);

        // Enforce page-level access only if some permissions are defined
        if (!empty($pagePermissions)) {
            $route = $request->route();
            $routeName = $route ? $route->getName() : null;

            if ($routeName) {
                $accessKey = null;

                if ($routeName === 'dashboard') {
                    $accessKey = 'dashboard';
                } elseif (str_starts_with($routeName, 'myinfo')) {
                    $accessKey = 'my-info';
                } elseif ($routeName === 'pim' || str_starts_with($routeName, 'pim.')) {
                    $accessKey = 'pim';
                } elseif ($routeName === 'leave' || str_starts_with($routeName, 'leave.')) {
                    $accessKey = 'leave';
                } elseif (str_starts_with($routeName, 'time.')) {
                    $accessKey = 'time';
                } elseif ($routeName === 'recruitment' || str_starts_with($routeName, 'recruitment.')) {
                    $accessKey = 'recruitment';
                } elseif ($routeName === 'performance' || str_starts_with($routeName, 'performance.')) {
                    $accessKey = 'performance';
                } elseif ($routeName === 'claim' || str_starts_with($routeName, 'claim.')) {
                    $accessKey = 'claim';
                } elseif ($routeName === 'directory' || str_starts_with($routeName, 'directory.')) {
                    $accessKey = 'directory';
                } elseif ($routeName === 'buzz' || str_starts_with($routeName, 'buzz.')) {
                    $accessKey = 'buzz';
                } elseif ($routeName === 'admin' || str_starts_with($routeName, 'admin.')) {
                    // Allow theme colors endpoint for all authenticated users (needed for CSS)
                    if ($routeName === 'admin.theme-manager.get-colors') {
                        // Skip permission check for theme colors endpoint
                        return $next($request);
                    }
                    $accessKey = 'admin';
                }

                if ($accessKey && !in_array($accessKey, $pagePermissions, true)) {
                    return redirect()->route('dashboard')
                        ->with('error', 'You do not have access to this page.');
                }
            }
        }

        return $next($request);
    }
}
