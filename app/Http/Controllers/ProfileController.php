<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function about()
    {
        // Return JSON for modal or view
        return response()->json([
            'company_name' => 'TOAI HR',
            'version' => 'TOAI HR OS 1.0',
            'active_employees' => 151,
            'employees' => 3,
            'terminated' => ''
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
