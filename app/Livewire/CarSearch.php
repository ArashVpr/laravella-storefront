<?php

namespace App\Livewire;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;

class CarSearch extends Component
{
    use WithPagination;

    // Search properties
    public $q = '';
    public $maker_id = '';
    public $model_id = '';
    public $city_id = '';
    public $state_id = '';
    public $car_type_id = '';
    public $fuel_type_id = '';
    public $year_from = '';
    public $year_to = '';
    public $price_from = '';
    public $price_to = '';
    public $mileage = '';
    public $sort = '-created_at';

    // Update search when any property changes
    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'q', 'maker_id', 'model_id', 'city_id', 'state_id',
            'car_type_id', 'fuel_type_id', 'year_from', 'year_to',
            'price_from', 'price_to', 'mileage'
        ]);
        $this->resetPage();
    }

    public function render()
    {
        // Build Eloquent query
        $query = Car::query()->with(['primaryImage', 'city.state', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers']);

        // Apply text search if provided
        if (!empty($this->q)) {
            $query->where(function ($query) {
                $query->where('description', 'like', "%{$this->q}%")
                    ->orWhereHas('maker', function ($query) {
                        $query->where('name', 'like', "%{$this->q}%");
                    })
                    ->orWhereHas('model', function ($query) {
                        $query->where('name', 'like', "%{$this->q}%");
                    })
                    ->orWhereHas('fuelType', function ($query) {
                        $query->where('name', 'like', "%{$this->q}%");
                    })
                    ->orWhereHas('carType', function ($query) {
                        $query->where('name', 'like', "%{$this->q}%");
                    })
                    ->orWhere('year', 'like', "%{$this->q}%");
            });
        }

        // Apply filters
        if ($this->maker_id) {
            $query->where('maker_id', $this->maker_id);
        }
        if ($this->model_id) {
            $query->where('model_id', $this->model_id);
        }
        if ($this->city_id) {
            $query->where('city_id', $this->city_id);
        }
        if ($this->state_id) {
            $query->whereHas('city', function ($query) {
                $query->where('state_id', $this->state_id);
            });
        }
        if ($this->car_type_id) {
            $query->where('car_type_id', $this->car_type_id);
        }
        if ($this->fuel_type_id) {
            $query->where('fuel_type_id', $this->fuel_type_id);
        }
        if ($this->year_from) {
            $query->where('year', '>=', $this->year_from);
        }
        if ($this->year_to) {
            $query->where('year', '<=', $this->year_to);
        }
        if ($this->price_from) {
            $query->where('price', '>=', $this->price_from);
        }
        if ($this->price_to) {
            $query->where('price', '<=', $this->price_to);
        }
        if ($this->mileage) {
            $query->where('mileage', '<=', $this->mileage);
        }

        // Apply sorting
        if (str_starts_with($this->sort, '-')) {
            $sortField = substr($this->sort, 1);
            $sortOrder = 'desc';
        } else {
            $sortField = $this->sort;
            $sortOrder = 'asc';
        }

        // Validate sort field
        $allowedSortFields = ['price', 'year', 'created_at', 'mileage'];
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $cars = $query->paginate(15);

        return view('livewire.car-search', ['cars' => $cars]);
    }
}
