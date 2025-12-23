<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerifyController
{
    public function verify(EmailVerificationRequest $request)
    {
        // Will be called when user clicks on the verification link in email
        $request->fulfill();

        // Redirect to the homepage or any other page
        return redirect()->route('homepage')->with('success', 'Email verified successfully. You can now add new cars!');
    }

    public function notice()
    {
        // Will be called if we setup verified middleware, so that only
        // verified users to be able to access certain routes
        return view('auth.verify-email');
    }

    public function send(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent');

        // Will be called, if user loses his/her verification link and wants
        // to resend the verification email
    }
}
