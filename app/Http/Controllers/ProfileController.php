<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'required|string|max:255',
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Get current logged-in user
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        if (!$userId) {
            return redirect()->back()
                ->withErrors(['error' => 'User session not found. Please login again.']);
        }

        // Get user from database
        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['error' => 'User not found.']);
        }

        // Verify current password using hash
        if (!$user->password_hash) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password hash not found. Please contact administrator.']);
        }

        $currentPasswordValid = Hash::check($request->current_password, $user->password_hash);

        if (!$currentPasswordValid) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Check if username already exists (if changed)
        if ($request->username !== $user->username) {
            $usernameExists = DB::table('users')
                ->where('username', $request->username)
                ->where('id', '!=', $userId)
                ->exists();

            if ($usernameExists) {
                return redirect()->back()
                    ->withErrors(['username' => 'Username already exists. Please choose a different username.']);
            }
        }

        // Hash the new password
        $hashedPassword = Hash::make($request->password);

        // Update username and password in database
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'username' => $request->username,
                'password_hash' => $hashedPassword,
                'updated_at' => now(),
            ]);

        // Update session if username changed
        if ($request->username !== $user->username) {
            $request->session()->put('auth_user', [
                'id' => $user->id,
                'name' => $request->username,
                'username' => $request->username,
            ]);
        }

        return redirect()->back()->with('success', 'Password and username updated successfully.');
    }
}
