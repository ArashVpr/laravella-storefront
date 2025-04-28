<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::where('created_at', '<', now())
        ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
        ->orderBy('created_at','desc')
        ->limit(30)
        ->get();

        return view('home.index',['cars' => $cars]);
    }
}
