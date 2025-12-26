<?php

namespace App\GraphQL\Mutations;

class Logout
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        
        // Revoke all tokens
        $user->tokens()->delete();
        
        return [
            'message' => 'Successfully logged out',
            'success' => true,
        ];
    }
}
