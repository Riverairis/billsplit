<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/u',
            'first_name' => 'required|string|max:255|regex:/^[a-zA-Z]+$/u',
            'nickname' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9]+$/u',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users|regex:/^[a-zA-Z0-9_]+$/u',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'account_type' => 'standard',
        ]);

        // Send welcome email with login link
        Mail::to($user->email)->send(new RegistrationConfirmation($user));

        return redirect()->route('login')
            ->with('status', 'Registration successful! Check your email for a login link.');
    }

    protected function create(array $data)
{
    $user = User::create([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'account_type' => 'standard' // or whatever your default is
    ]);

    // Handle invitation if present
    if (isset($data['invitation_token'])) {
        $invitation = Invitation::where('token', $data['invitation_token'])
                              ->where('expires_at', '>', now())
                              ->first();

        if ($invitation) {
            $bill = $invitation->bill;
            $bill->participants()->attach($user->id);
            $invitation->delete();
        }
    }

    return $user;
}
}