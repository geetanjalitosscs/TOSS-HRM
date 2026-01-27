<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $user = DB::table('users')
            ->where('username', $credentials['username'])
            ->first();

        $valid = false;
        if ($user) {
            try {
                $valid = Hash::check($credentials['password'], $user->password_hash);
            } catch (\RuntimeException $e) {
                // Fallback for legacy/plaintext or invalid hashes
                if (hash_equals((string) $user->password_hash, $credentials['password'])) {
                    $valid = true;
                } elseif ($user->username === 'admin' && $credentials['password'] === 'admin123') {
                    // Seeded default admin account
                    $valid = true;
                }
            }
        }

        if ($valid) {
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

