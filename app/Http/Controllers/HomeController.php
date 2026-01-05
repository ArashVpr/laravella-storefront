<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        // Get featured cars (active featured listings)
        $featuredCars = Cache::remember('home-featured-cars', 30, function () {
            return Car::where('is_featured', true)
                ->where('featured_until', '>', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers'])
                ->orderBy('featured_until', 'desc')
                ->limit(6)
                ->get();
        });

        // Get latest cars (excluding already featured ones)
        $cars = Cache::remember('home-latest-cars', 60, function () use ($featuredCars) {
            return Car::whereNotIn('id', $featuredCars->pluck('id'))
                ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers'])
                ->orderBy('created_at', 'desc')
                ->limit(24)
                ->get();
        });

        return view('home.index', [
            'featuredCars' => $featuredCars,
            'cars' => $cars
        ]);
    }
}
