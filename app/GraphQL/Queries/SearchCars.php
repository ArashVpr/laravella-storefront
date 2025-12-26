<?php

namespace App\GraphQL\Queries;

use App\Models\Car;

class SearchCars
{
    public function __invoke($root, array $args)
    {
        $search = $args['search'] ?? '';
        $minPrice = $args['minPrice'] ?? null;
        $maxPrice = $args['maxPrice'] ?? null;
        $minYear = $args['minYear'] ?? null;
        $maxYear = $args['maxYear'] ?? null;
        
        $query = Car::query();
        
        // Search in make, model, and description
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('make', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        // Price range filter
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        
        // Year range filter
        if ($minYear !== null) {
            $query->where('year', '>=', $minYear);
        }
        if ($maxYear !== null) {
            $query->where('year', '<=', $maxYear);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }
}
