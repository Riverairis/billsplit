<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'nickname' => 'required|string|max:255|unique:users,nickname,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['last_name', 'first_name', 'nickname', 'email']));

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function upgradeAccount()
    {
        $user = auth()->user();
        
        if ($user->isStandard()) {
            // Process payment here (simplified for example)
            $user->update(['account_type' => 'premium']);
            return back()->with('success', 'Account upgraded to premium!');
        }

        return back()->with('error', 'You can only upgrade from a standard account.');
    }
}