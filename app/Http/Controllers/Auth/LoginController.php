<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Display the HR login page.
     */
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = DB::table('users')
            ->where('username', $credentials['username'])
            ->whereNull('deleted_at')
            ->first();

        $valid = false;
        if ($user && $user->password_hash) {
            // Only use hash matching - no plaintext login
            $valid = Hash::check($credentials['password'], $user->password_hash);
        }

        if ($valid) {
            // Check if user is active
            if (isset($user->is_active) && $user->is_active != 1) {
                return back()
                    ->withErrors(['login' => 'Your account is inactive. Please contact HR.'])
                    ->withInput($request->only('username'));
            }

            // Handle remember me - extend session lifetime
            if ($request->has('remember') && $request->remember == '1') {
                // Set session lifetime to 30 days (43200 minutes)
                config(['session.lifetime' => 43200]);
            }

            $request->session()->put('auth_user', [
                'id'       => $user->id,
                'name'     => $user->username,
                'username' => $user->username,
            ]);

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['login' => 'Invalid username or password.'])
            ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Display the forgot password page.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle password reset request.
     */
    public function sendPasswordReset(Request $request)
    {
        $request->validate([
            'username_or_email' => ['required', 'string'],
        ]);

        // Find user by username or email
        $user = DB::table('users')
            ->where(function($query) use ($request) {
                $query->where('username', $request->username_or_email)
                      ->orWhere('email', $request->username_or_email);
            })
            ->whereNull('deleted_at')
            ->first();

        if ($user && $user->email) {
            // Generate a secure random token
            $token = Str::random(64);
            
            // Set expiration time (60 minutes from now)
            $expiresAt = Carbon::now()->addMinutes(60);
            
            // Delete any existing reset tokens for this user
            DB::table('password_resets')
                ->where('user_id', $user->id)
                ->whereNull('used_at')
                ->delete();
            
            // Store the token in password_resets table
            DB::table('password_resets')->insert([
                'user_id' => $user->id,
                'token' => $token,
                'expires_at' => $expiresAt,
                'used_at' => null,
                'created_at' => Carbon::now(),
            ]);
            
            // Send email with reset link
            try {
                Mail::to($user->email)->send(new PasswordResetMail($user, $token));
                
                // Mask email for security (show only first 2 chars and domain)
                $emailParts = explode('@', $user->email);
                $maskedEmail = substr($emailParts[0], 0, 2) . '***@' . $emailParts[1];
                
                return back()->with('status', 'If a user with that username or email exists, password reset instructions have been sent to ' . $maskedEmail . '.');
            } catch (\Exception $e) {
                // Log error but still show success message for security
                \Log::error('Password reset email failed: ' . $e->getMessage());
                return back()->with('status', 'If a user with that username or email exists, password reset instructions have been sent.');
            }
        }

        // Always show success message for security (don't reveal if user exists)
        return back()->with('status', 'If a user with that username or email exists, password reset instructions have been sent.');
    }

    /**
     * Display the reset password page.
     */
    public function showResetPassword($token)
    {
        // Check if token exists and is valid
        $reset = DB::table('password_resets')
            ->where('token', $token)
            ->whereNull('used_at')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return redirect()->route('password.forgot')
                ->withErrors(['token' => 'This password reset link is invalid or has expired.']);
        }

        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset submission.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Find the reset token
        $reset = DB::table('password_resets')
            ->where('token', $request->token)
            ->whereNull('used_at')
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$reset) {
            return back()
                ->withErrors(['token' => 'This password reset link is invalid or has expired.'])
                ->withInput();
        }

        // Get the user
        $user = DB::table('users')
            ->where('id', $reset->user_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['token' => 'User not found.'])
                ->withInput();
        }

        // Update the password
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password_hash' => Hash::make($request->password),
                'updated_at' => Carbon::now(),
            ]);

        // Mark the token as used
        DB::table('password_resets')
            ->where('id', $reset->id)
            ->update(['used_at' => Carbon::now()]);

        // Delete all other unused tokens for this user
        DB::table('password_resets')
            ->where('user_id', $user->id)
            ->whereNull('used_at')
            ->delete();

        return redirect()->route('login')
            ->with('status', 'Your password has been reset successfully. Please login with your new password.');
    }
}
