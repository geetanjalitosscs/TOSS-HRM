<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Show Administrator Access page
     * Always show auth page - clear any existing maintenance auth session
     */
    public function showAuth()
    {
        // Always clear maintenance auth session to force re-authentication
        session()->forget('maintenance_auth');
        
        return view('maintenance.auth');
    }

    /**
     * Handle maintenance authentication
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Simple authentication: admin / admin123
        if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin123') {
            $request->session()->put('maintenance_auth', true);
            return redirect()->route('maintenance.purge-employee');
        }

        return back()
            ->withErrors(['login' => 'Invalid username or password.'])
            ->withInput($request->only('username'));
    }

    /**
     * Show main maintenance page with tabs
     * Default: redirect to Employee Records
     */
    public function index()
    {
        // Check if authenticated for maintenance
        if (!session()->has('maintenance_auth')) {
            return redirect()->route('maintenance.auth');
        }

        // By default, show Employee Records page
        return redirect()->route('maintenance.purge-employee');
    }

    /**
     * Show Purge Employee Records page
     */
    public function purgeEmployee()
    {
        if (!session()->has('maintenance_auth')) {
            return redirect()->route('maintenance.auth');
        }

        return view('maintenance.purge-employee');
    }

    /**
     * Show Purge Candidate Records page
     */
    public function purgeCandidate()
    {
        if (!session()->has('maintenance_auth')) {
            return redirect()->route('maintenance.auth');
        }

        return view('maintenance.purge-candidate');
    }

    /**
     * Show Access Records page
     */
    public function accessRecords()
    {
        if (!session()->has('maintenance_auth')) {
            return redirect()->route('maintenance.auth');
        }

        return view('maintenance.access-records');
    }
}

