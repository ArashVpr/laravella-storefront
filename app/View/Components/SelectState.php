<?php

namespace App\View\Components;

use App\Models\State;
use Illuminate\Support\Facades\DB;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectState extends Component
{
    /** @var Collection<int, State> */
    public Collection $states;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->states = Cache::rememberForever('states', function () {
            return State::select(DB::raw('MIN(id) as id'), 'name')
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
        return view('components.select-state');
    }
}
