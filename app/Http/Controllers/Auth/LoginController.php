<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display the HR login page.
     */
    public function show()
    {
        return view('auth.login');
    }

    /**
     * Handle the login POST request.
     * For now we use a simple hard-coded user: admin / admin123
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'admin123') {
            $request->session()->put('auth_user', [
                'name' => 'Admin',
                'username' => 'admin',
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
