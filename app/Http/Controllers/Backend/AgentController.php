<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index()
    {
        return view('backend.pages.agents.index');
    }
    public function create()
    {
        $html = view('backend.pages.agents.create')->render();
        $response = [
            'success' => true,
            'html' => $html
        ];
        return response()->json($response);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        try {
            if ($request->hasFile('profile_image')) {
                $profileImage = $request->file('profile_image');
                $destinationPath = public_path('uploads/users');
                $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
                $profileImage->move($destinationPath, $profileImageName);
                $profileImagePath = 'uploads/users/' . $profileImageName;
            }


            // Save the user
            $user = new User();
            $user->first_name = $validated['first_name'];
            $user->last_name = $validated['last_name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->password = Hash::make($validated['password']);
            $user->profile_image = $profileImagePath;
            $user->save();

            return response()->json(['success' => true, 'msg' => 'User saved successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'msg' => $e->getMessage()], 500);
        }
    }
    public function edit()
    {
        return view('backend.pages.agents.index');
    }
    public function update()
    {
        return view('backend.pages.agents.index');
    }
    public function delete()
    {
        return view('backend.pages.agents.index');
    }
}
