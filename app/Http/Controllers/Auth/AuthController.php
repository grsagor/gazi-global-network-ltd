<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function myProfile() {
        $user = Auth::user();
        return view('auth.pages.my-profile', compact('user'));
    }

    public function updateMyProfile(Request $request)
    {
        $user = User::find(Auth::user()->id);

        // Validate the request
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // Update profile image if provided
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image');
            $destinationPath = public_path('uploads/users');
            $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
            $profileImage->move($destinationPath, $profileImageName);
            $profileImagePath = 'uploads/users/' . $profileImageName;

            // Delete the old profile image if it exists
            if ($user->profile_image && file_exists(public_path($user->profile_image))) {
                unlink(public_path($user->profile_image));
            }

            $user->profile_image = $profileImagePath;
        }

        // Update other user fields
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save the user
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
