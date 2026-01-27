<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function about()
    {
        $totalEmployees = DB::table('employees')->count();
        $activeEmployees = DB::table('employees')->where('status', 'active')->count();
        $terminatedEmployees = DB::table('employees')->where('status', 'terminated')->count();

        // Version is still static (no dedicated table for it yet)
        return response()->json([
            'company_name'      => 'TOAI HR',
            'version'           => 'TOAI HR OS 1.0',
            'active_employees'  => $activeEmployees,
            'employees'         => $totalEmployees,
            'terminated'        => $terminatedEmployees,
        ]);
    }

    public function support()
    {
        return view('profile.support');
    }

    public function changePassword()
    {
        return view('profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // For now, just return success
        // In real app, verify current password and update
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
