<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            ->first();

        $valid = false;
        if ($user && $user->password_hash) {
            // Only use hash matching - no plaintext login
                $valid = Hash::check($credentials['password'], $user->password_hash);
        }

        if ($valid) {
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
}
