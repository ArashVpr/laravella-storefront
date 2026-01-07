<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\CarType;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Models;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class CarSearch extends Component
{
    use WithPagination;

    // Search Params
    public $q = '';
    public $maker_id = '';
    public $model_id = '';
    public $car_type_id = '';
    public $fuel_type_id = '';
    public $year_from = '';
    public $year_to = '';
    public $price_from = '';
    public $price_to = '';
    public $mileage = '';
    public $sort = '-created_at';
    
    // UI State
    public $showFilters = false;

    // Query String Binding
    protected $queryString = [
        'q' => ['except' => ''],
        'maker_id' => ['except' => ''],
        'model_id' => ['except' => ''],
        'car_type_id' => ['except' => ''],
        'fuel_type_id' => ['except' => ''],
        'year_from' => ['except' => ''],
        'year_to' => ['except' => ''],
        'price_from' => ['except' => ''],
        'price_to' => ['except' => ''],
        'mileage' => ['except' => ''],
        'sort' => ['except' => '-created_at'],
    ];

    public function updating($property)
    {
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function resetFilters()
    {
        $this->reset([
            'q', 'maker_id', 'model_id', 'car_type_id', 
            'fuel_type_id', 'year_from', 'year_to', 
            'price_from', 'price_to', 'mileage', 'sort'
        ]);
    }

    public function toggleWatchlist($carId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $user->favoriteCars()->toggle($carId);
    }

    public function render()
    {
        $query = Car::query()
            ->with(['primaryImage', 'city.state', 'carType', 'fuelType', 'maker', 'model']);
        
        if (Auth::check()) {
            $query->withExists(['favoredUsers as in_watchlist' => function ($q) {
                $q->where('user_id', Auth::id());
            }]);
        }

        // 1. Text Search
        if (!empty($this->q)) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->q}%")
                  ->orWhereHas('maker', fn($k) => $k->where('name', 'like', "%{$this->q}%"))
                  ->orWhereHas('model', fn($k) => $k->where('name', 'like', "%{$this->q}%"))
                  ->orWhereHas('fuelType', fn($k) => $k->where('name', 'like', "%{$this->q}%"))
                  ->orWhereHas('carType', fn($k) => $k->where('name', 'like', "%{$this->q}%"))
                  ->orWhere('year', 'like', "%{$this->q}%");
            });
        }

        // 2. Filters
        if ($this->maker_id) $query->where('maker_id', $this->maker_id);
        if ($this->model_id) $query->where('model_id', $this->model_id);
        if ($this->car_type_id) $query->where('car_type_id', $this->car_type_id);
        if ($this->fuel_type_id) $query->where('fuel_type_id', $this->fuel_type_id);
        
        if ($this->year_from) $query->where('year', '>=', $this->year_from);
        if ($this->year_to) $query->where('year', '<=', $this->year_to);
        
        if ($this->price_from) $query->where('price', '>=', $this->price_from);
        if ($this->price_to) $query->where('price', '<=', $this->price_to);
        
        if ($this->mileage) $query->where('mileage', '<=', $this->mileage);

        // 3. Sorting
        if ($this->sort === 'price') $query->orderBy('price', 'asc');
        elseif ($this->sort === '-price') $query->orderBy('price', 'desc');
        elseif ($this->sort === 'year') $query->orderBy('year', 'asc');
        elseif ($this->sort === '-year') $query->orderBy('year', 'desc');
        elseif ($this->sort === 'mileage') $query->orderBy('mileage', 'asc');
        elseif ($this->sort === '-mileage') $query->orderBy('mileage', 'desc');
        elseif ($this->sort === 'created_at') $query->orderBy('created_at', 'desc');
        elseif ($this->sort === '-created_at') $query->orderBy('created_at', 'asc');
        else $query->orderBy('created_at', 'desc');

        $cars = $query->paginate(12);

        // Fetch options
        $makers = Maker::orderBy('name')->get()->unique('name');
        
        $models = $this->maker_id 
            ? Models::where('maker_id', $this->maker_id)->orderBy('name')->get() 
            : collect([]);

        $carTypes = CarType::orderBy('name')->get();
        $fuelTypes = FuelType::orderBy('name')->get();

        return view('livewire.car-search', [
            'cars' => $cars,
            'makers' => $makers,
            'models' => $models,
            'carTypes' => $carTypes,
            'fuelTypes' => $fuelTypes,
        ]);
    }
}
