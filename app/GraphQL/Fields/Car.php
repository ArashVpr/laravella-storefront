<?php

namespace App\GraphQL\Fields;

use App\Models\Car as CarModel;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class Car
{
    /**
     * Check if the car is in the current user's watchlist
     */
    public function inWatchlist(CarModel $rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): bool
    {
        $user = $context->user();
        
        if (!$user) {
            return false;
        }
        
        return $user->favoriteCars()->where('car_id', $rootValue->id)->exists();
    }
    
    /**
     * Get car images from Spatie Media Library
     */
    public function images(CarModel $rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        $media = $rootValue->getMedia('car-images');
        
        return $media->map(function ($mediaItem) {
            return [
                'id' => $mediaItem->id,
                'url' => $mediaItem->getUrl(),
                'thumbnailUrl' => $mediaItem->getUrl('thumb'),
                'isPrimary' => $mediaItem->getCustomProperty('is_primary', false),
                'order' => $mediaItem->order_column,
            ];
        })->toArray();
    }
}
