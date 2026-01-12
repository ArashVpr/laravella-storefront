<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function create(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Get Validated data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Try to authenticate with given email and password
        if (Auth::attempt($credentials)) {
            // If that was successful, regenerate session
            $request->session()->regenerate();

            // and redirect user to home page. But if user is coming from another page to login page, redirect to that
            // intended page
            return redirect()->intended(route('homepage'))
                ->with('success', __('Welcome Back'));
        }

        // If attempt was not successful, redirect back into login form with error on email and with email input data
        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }

    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();
        // Regenerate session
        $request->session()->regenerate();
        // Regenerate CSRF Token
        $request->session()->regenerateToken();

        return redirect()->route('homepage')
            ->with('success', __('You have been logged out'));
    }
}
