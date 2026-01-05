<?php

namespace App\View\Components;

use App\Models\FuelType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectRadioFuelType extends Component
{
    /** @var Collection<int, FuelType> */
    public Collection $radioFuelTypes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->radioFuelTypes = FuelType::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-radio-fuel-type');
    }
}
