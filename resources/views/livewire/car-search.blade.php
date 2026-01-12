<div class="min-h-screen bg-gray-50 pb-20">
    <!-- Search Header -->
    <div class="bg-white border-b border-gray-200 sticky top-16 z-30 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Input -->
                <div class="relative w-full md:max-w-xl">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input wire:model.live.debounce.300ms="q"
                        type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-gray-50 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm transition duration-150 ease-in-out"
                        placeholder="Search by make, model, or keywords..." />
                </div>

                <!-- Sort & Filter Toggle -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <button wire:click="toggleFilters" class="md:hidden flex-1 inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Filters
                    </button>

                    <select wire:model.live="sort" class="flex-1 md:flex-none form-select block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="-created_at">Newest First</option>
                        <option value="created_at">Oldest First</option>
                        <option value="price">Price: Low to High</option>
                        <option value="-price">Price: High to Low</option>
                        <option value="mileage">Mileage: Low to High</option>
                        <option value="-mileage">Mileage: High to Low</option>
                    </select>
                </div>
            </div>

            <!-- Active Filters Badges -->
            @if($maker_id || $car_type_id || $price_to || $q || $model_id || $fuel_type_id)
            <div class="flex flex-wrap gap-2 mt-4">
                <button wire:click="resetFilters" class="text-xs text-primary hover:underline font-medium">Clear all</button>
                @if($maker_id) <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">Maker Selected</span> @endif
                {{-- Add more badges here as needed --}}
            </div>
            @endif
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">

            <!-- Sidebar Filters (Desktop) -->
            <aside class="w-full md:w-64 flex-shrink-0 {{ $showFilters ? 'block' : 'hidden md:block' }}">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-40 space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Manufacturer</h3>
                        <select wire:model.live="maker_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">All Makes</option>
                            @foreach($makers as $make)
                            <option value="{{ $make->id }}">{{ $make->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(!empty($models) && count($models) > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Model</h3>
                        <select wire:model.live="model_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <option value="">All Models</option>
                            @foreach($models as $model)
                            <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Price Range</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <input wire:model.live.debounce.500ms="price_from" type="number" placeholder="Min" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <input wire:model.live.debounce.500ms="price_to" type="number" placeholder="Max" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Year</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <input wire:model.live.debounce.500ms="year_from" type="number" placeholder="From" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <input wire:model.live.debounce.500ms="year_to" type="number" placeholder="To" class="w-full rounded-md border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" class="rounded text-primary focus:ring-primary" wire:click="resetFilters">
                            <span class="text-sm text-gray-600">Reset All Filters</span>
                        </label>
                    </div>
                </div>
            </aside>

            <!-- Results Grid -->
            <main class="flex-1">
                <div wire:loading.class="opacity-50 pointer-events-none" class="transition-opacity duration-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($cars as $car)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                            <!-- Image -->
                            <div class="relative aspect-[16/10] overflow-hidden bg-gray-200">
                                @if($car->primaryImage)
                                <a href="{{ route('car.show', $car) }}" class="block w-full h-full">
                                    <img src="{{ $car->primaryImage->getUrl() }}" alt="{{ $car->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </a>
                                @else
                                <a href="{{ route('car.show', $car) }}" class="block w-full h-full">
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </a>
                                @endif
                                <div class="absolute top-3 right-3">
                                    <button wire:click.prevent="toggleWatchlist({{ $car->id }})"
                                        class="p-2 rounded-full bg-white/90 backdrop-blur transition-colors shadow-sm {{ ($car->in_watchlist ?? false) ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="{{ ($car->in_watchlist ?? false) ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/60 to-transparent text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-xs font-medium">{{ $car->city->name ?? '' }}, {{ $car->city->state->name ?? '' }}</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <p class="text-xs font-semibold tracking-wide uppercase text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full">
                                        {{ $car->year }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $car->created_at->diffForHumans() }}</p>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                                    <a href="{{ route('car.show', $car) }}">
                                        {{ $car->maker->name }} {{ $car->model->name }}
                                    </a>
                                </h3>

                                <div class="flex items-baseline gap-1 mb-4">
                                    <span class="text-xl font-bold text-gray-900">${{ number_format($car->price) }}</span>
                                </div>

                                <div class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm text-gray-500 mt-auto pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        {{ $car->fuelType ? __('fuel_types.'.$car->fuelType->name) : 'N/A' }}
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        {{ $car->formatted_mileage }}
                                    </div>
                                    <div class="flex items-center gap-1.5 col-span-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                        {{ $car->carType->name ?? 'Vehicle' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-12 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">No cars found</h3>
                            <p class="mt-1 text-gray-500">Try adjusting your filters or search query.</p>
                            <button wire:click="resetFilters" class="mt-4 text-primary hover:text-primary-700 font-medium">Clear all filters</button>
                        </div>
                        @endforelse
                    </div>

                    <div class="mt-8">
                        {{ $cars->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>