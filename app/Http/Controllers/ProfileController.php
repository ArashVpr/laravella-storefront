<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController
{
    public function index()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'unique:users,phone,'.Auth::id()],
        ];

        if (! $user->isOauthUser()) {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:users,email,'.Auth::id()];
        }

        $data = $request->validate($rules);

        // If the email is changed we need to send email verification and we need to mark the user with
        // email_verified_at=null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $success = 'Email Verification was sent. Please verify!';
        }

        $user->update($data);
        $success = 'Profile updated successfully';

        return redirect()->route('profile.index')->with('success', $success);
    }

    public function updatePassword(Request $request)
    {
        // Validate current password and new password
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'confirmed',
                Password::min(8)
                    ->max(24)
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised()],
        ]);

        // Perform password update
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        // Go back with success message
        return back()->with('success', 'Password updated successfully');
    }
}
