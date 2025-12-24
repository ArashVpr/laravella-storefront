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
        // Check if we have any search criteria
        $hasFilters = $this->maker_id || $this->model_id || $this->city_id || 
                      $this->state_id || $this->car_type_id || $this->fuel_type_id || 
                      $this->year_from || $this->year_to || $this->price_from || 
                      $this->price_to || $this->mileage;
        
        $useScout = !empty($this->q) || $hasFilters;

        if ($useScout) {
            // Use Meilisearch
            $filters = [];

            // Build filters
            if ($this->maker_id) {
                $maker = \App\Models\Maker::find($this->maker_id);
                if ($maker) {
                    $filters[] = 'maker = "' . addslashes($maker->name) . '"';
                }
            }
            if ($this->model_id) {
                $model = \App\Models\Models::find($this->model_id);
                if ($model) {
                    $filters[] = 'model = "' . addslashes($model->name) . '"';
                }
            }
            if ($this->city_id) {
                $city = \App\Models\City::find($this->city_id);
                if ($city) {
                    $filters[] = 'city = "' . addslashes($city->name) . '"';
                }
            }
            if ($this->state_id) {
                $state = \App\Models\State::find($this->state_id);
                if ($state) {
                    $filters[] = 'state = "' . addslashes($state->name) . '"';
                }
            }
            if ($this->car_type_id) {
                $carType = \App\Models\CarType::find($this->car_type_id);
                if ($carType) {
                    $filters[] = 'car_type = "' . addslashes($carType->name) . '"';
                }
            }
            if ($this->fuel_type_id) {
                $fuelType = \App\Models\FuelType::find($this->fuel_type_id);
                if ($fuelType) {
                    $filters[] = 'fuel_type = "' . addslashes($fuelType->name) . '"';
                }
            }
            if ($this->year_from) {
                $filters[] = 'year >= ' . $this->year_from;
            }
            if ($this->year_to) {
                $filters[] = 'year <= ' . $this->year_to;
            }
            if ($this->price_from) {
                $filters[] = 'price >= ' . $this->price_from;
            }
            if ($this->price_to) {
                $filters[] = 'price <= ' . $this->price_to;
            }
            if ($this->mileage) {
                $filters[] = 'mileage <= ' . $this->mileage;
            }

            // Determine sort
            $sortField = str_starts_with($this->sort, '-') ? substr($this->sort, 1) : $this->sort;
            $sortOrder = str_starts_with($this->sort, '-') ? 'desc' : 'asc';

            $sortableFields = ['price', 'year', 'created_at', 'mileage'];
            if (!in_array($sortField, $sortableFields)) {
                $sortField = 'created_at';
            }

            $cars = Car::search($this->q, function ($meilisearch, $query, $options) use ($filters, $sortField, $sortOrder) {
                if (!empty($filters)) {
                    $options['filter'] = implode(' AND ', $filters);
                }
                $options['sort'] = [$sortField . ':' . $sortOrder];
                return $meilisearch->search($query, $options);
            })
            ->query(function ($query) {
                return $query->with(['primaryImage', 'city.state', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers']);
            })
            ->paginate(15);
        } else {
            // Fallback to Eloquent
            $query = Car::where('created_at', '<', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model', 'favoredUsers']);

            if (str_starts_with($this->sort, '-')) {
                $sortBy = substr($this->sort, 1);
                $query->orderBy($sortBy, 'desc');
            } else {
                $query->orderBy($this->sort);
            }

            $cars = $query->paginate(15);
        }

        return view('livewire.car-search', ['cars' => $cars]);
    }
}
