<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.pages.login');
    }
    public function loginPost(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard.index')->with('success', 'Logged in successfully.'); // Redirect to intended page or dashboard
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }
    public function logout(Request $request) {
        Auth::logout(); // Log out the user
    
        // Invalidate and regenerate session token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Redirect to login page
        return redirect()->route('auth.login');
    }
}
