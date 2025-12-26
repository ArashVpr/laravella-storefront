<?php

namespace App\GraphQL\Queries;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;

class MyWatchlist
{
    public function __invoke($root, array $args, $context)
    {
        $user = $context->user();
        
        return $user->watchlist()->get();
    }
}
