<?php

namespace App\View\Components;

use App\Models\CarType;
use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectCarType extends Component
{
    public Collection $carTypes;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->carTypes = Cache::rememberForever('carTypes', function () {
            return CarType::select(DB::raw('MIN(id) as id'), 'name')
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
        return view('components.select-car-type');
    }
}
