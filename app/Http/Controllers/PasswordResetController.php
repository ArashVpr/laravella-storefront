<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController
{
    public function showForgotPassword(): \Illuminate\View\View
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        // If email was sent redirect user back with success message
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', __($status));
        }

        // If there was an error, redirect user back with email error and with email input
        return back()->withErrors(['email' => __($status)])
            ->withInput($request->only('email'));
    }

    public function showResetPassword(): \Illuminate\View\View
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'string',
                'confirmed',
                PasswordRule::min(8)
                    ->max(24)
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $status = Password::reset(
            $request->only(['email', 'password', 'password_confirmation', 'token']),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        // If password was reset redirect user back with success message
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', __($status));
        }

        // If there was an error, redirect user back with email error and with email input
        return back()->withErrors(['email' => __($status)]);
    }
}
