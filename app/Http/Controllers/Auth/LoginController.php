<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Bill;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
{
    // Pre-fill invitation code if coming from email
    $code = $request->get('code');
    
    return view('auth.login', [
        'prefilledCode' => $code
    ]);
}
protected function authenticated(Request $request, $user)
    {
        // Check if there's an intended URL first
        if ($request->session()->has('url.intended')) {
            return redirect()->intended();
        }
        
        // Check if coming from invitation
        if ($request->has('invitation_code')) {
            $bill = Bill::where('invitation_code', $request->invitation_code)->first();
            if ($bill) {
                return redirect()->route('bills.show', $bill);
            }
        }
        
        // Default redirect
        return redirect()->route('bills.index');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'invitation_code' => ['nullable', 'string'],
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            // Handle invitation code if provided
            if ($request->invitation_code) {
                $bill = Bill::where('invitation_code', $request->invitation_code)->first();
                if ($bill) {
                    $bill->participants()->attach(Auth::id());
                    return redirect()->route('bills.show', $bill);
                }
                return redirect()->route('dashboard')->with('warning', 'Invalid invitation code');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}