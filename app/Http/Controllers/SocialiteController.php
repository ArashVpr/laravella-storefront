<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController
{
    public function redirectToProvider($provider)
    {
        // Implement proper redirect to oauth provider
        return Socialite::driver($provider)->redirect();

    }

    public function handleCallback($provider)
    {
        // Put everything in try catch for safety reasons
        try {
            // Define the field from the user table which should be updated
            $field = null;
    
            // Based on the provider, let's set the correct value on field
            if ($provider === 'google') {
                $field = 'google_id';
            } elseif ($provider === 'facebook') {
                $field = 'facebook_id';
            }
    
            // Get the user information from the provider
            $user = Socialite::driver($provider)->stateless()->user();
    
            // Based on the email select user from the database
            $dbUser = User::where('email', $user->email)->first();
            // If the user already exists in the database we update its field
            if ($dbUser) {
                $dbUser->$field = $user->id;
                $dbUser->save();
            } else {
                // If the user does not exist in the database we create it
                $dbUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    $field => $user->id,
                    'email_verified_at' => now()
                ]);
            }
    
            // We also mark the user as authenticated
            Auth::login($dbUser);
            
            // And redirect to intended page or to home page
            return redirect()->intended(route('homepage'));
    
        } catch( \Exception $e) {
            // In case there is an error redirect user to login page and display the error message
            return redirect(route('login'))
                ->with('error', $e->getMessage() ?: 'Something went wrong');
        }
    }
}
