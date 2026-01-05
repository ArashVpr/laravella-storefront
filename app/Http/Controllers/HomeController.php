<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $cars = Cache::remember('home-cars', 60, function () {
            return Car::where('created_at', '<', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers'])
                ->orderBy('created_at', 'desc')
                ->limit(30)
                ->get();
        });

        return view('home.index', ['cars' => $cars]);
    }
}
