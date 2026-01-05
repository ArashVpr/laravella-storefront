<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected function authorizeAdmin()
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->authorizeAdmin();

        $usersCount = User::count();
        $carsCount = Car::count();

        return view('admin.dashboard', compact('usersCount', 'carsCount'));
    }

    public function users()
    {
        $this->authorizeAdmin();

        $users = User::orderBy('id', 'desc')->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function cars()
    {
        $this->authorizeAdmin();

        $cars = Car::with('user')->orderBy('id', 'desc')->paginate(20);

        return view('admin.cars', compact('cars'));
    }
}
