<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Register
{
    public function __invoke($root, array $args)
    {
        // Create the user
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => Hash::make($args['password']),
        ]);
        
        // Create a token for the user
        $token = $user->createToken('graphql-token')->plainTextToken;
        
        return [
            'user' => $user,
            'token' => $token,
            'expiresAt' => now()->addDays(30),
        ];
    }
}
