<?php

namespace App\View\Components;

use App\Models\FuelType;
use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectFuelType extends Component
{
    /** @var Collection<int, FuelType> */
    public Collection $fuelTypes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->fuelTypes = Cache::rememberForever('fuelTypes', function () {
            return FuelType::select(DB::raw('MIN(id) as id'), 'name')
                ->groupBy('name')
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-fuel-type');
    }
}
