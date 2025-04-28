<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SignupController extends Controller
{
    public function create()
    {
        return view('auth.signup');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->max(24)
                    ->numbers()
                    ->mixedCase()
                    ->symbols()
                    ->uncompromised()
            ]
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('homepage')->with('success', 'Account created successfully!');
    }
}
