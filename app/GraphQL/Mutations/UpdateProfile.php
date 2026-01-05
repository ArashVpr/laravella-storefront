<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UpdateProfile
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        
        // Verify current password
        if (!Hash::check($args['currentPassword'], $user->password)) {
            throw ValidationException::withMessages([
                'currentPassword' => ['The provided password does not match your current password.'],
            ]);
        }
        
        // Update name if provided
        if (isset($args['name'])) {
            $user->name = $args['name'];
        }
        
        // Update email if provided and check uniqueness
        if (isset($args['email']) && $args['email'] !== $user->email) {
            if (User::where('email', $args['email'])->exists()) {
                throw ValidationException::withMessages([
                    'email' => ['The email has already been taken.'],
                ]);
            }
            $user->email = $args['email'];
        }
        
        // Update password if provided
        if (isset($args['newPassword'])) {
            $user->password = Hash::make($args['newPassword']);
        }
        
        // Update phone if provided
        if (isset($args['phone'])) {
            $user->phone = $args['phone'];
        }
        
        $user->save();
        
        return $user;
    }
}
