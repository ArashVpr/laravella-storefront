<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login
{
    public function __invoke($root, array $args)
    {
        $user = User::where('email', $args['email'])->first();
        
        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        
        // Revoke old tokens if not remembering
        if (! ($args['remember'] ?? false)) {
            $user->tokens()->delete();
        }
        
        // Create a new token
        $token = $user->createToken('graphql-token')->plainTextToken;
        
        return [
            'user' => $user,
            'token' => $token,
            'expiresAt' => now()->addDays($args['remember'] ?? false ? 30 : 1),
        ];
    }
}
