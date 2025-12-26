<?php

namespace App\GraphQL\Queries;

use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Stats
{
    public function __invoke($root, array $args)
    {
        $totalCars = Car::count();
        $totalUsers = User::count();
        $averagePrice = Car::avg('price');
        
        // Get 5 newest listings with maker and model names
        $newestListings = Car::with(['maker', 'model'])
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($car) {
                return [
                    'id' => $car->id,
                    'make' => $car->maker->name ?? 'Unknown',
                    'model' => $car->model->name ?? 'Unknown',
                    'year' => $car->year,
                    'price' => $car->price,
                ];
            });
        
        // Get popular makes - count by maker_id and join with makers table
        $popularMakes = DB::table('cars')
            ->join('makers', 'cars.maker_id', '=', 'makers.id')
            ->whereNull('cars.deleted_at')
            ->select('makers.name as make', DB::raw('count(*) as count'))
            ->groupBy('makers.name', 'makers.id')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->map(fn($item) => [
                'make' => $item->make,
                'count' => $item->count
            ]);
        
        return [
            'totalCars' => $totalCars,
            'totalUsers' => $totalUsers,
            'averagePrice' => $averagePrice,
            'newestListings' => $newestListings->toArray(),
            'popularMakes' => $popularMakes->toArray(),
        ];
    }
}
