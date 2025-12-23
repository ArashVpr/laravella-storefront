<?php

namespace App\View\Components;

use App\Models\CarType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class SelectRadioCarType extends Component
{
    public Collection $radioCarTypes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->radioCarTypes = CarType::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-radio-car-type');
    }
}
