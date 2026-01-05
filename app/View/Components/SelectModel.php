<?php

namespace App\View\Components;

use App\Models\Models;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectModel extends Component
{
    /** @var Collection<int, Models> */
    public Collection $models;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->models = Cache::rememberForever('models', function () {
            return Models::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-model');
    }
}
