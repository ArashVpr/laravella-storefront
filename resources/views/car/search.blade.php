<x-app title="Search Cars" metaDescription="Search and find your perfect car from thousands of listings. Filter by make, model, price, year, location and more.">
    <div>
        <main>
            <!-- Found Cars -->
            <section>
                <div class="container">
                    <div class="sm:flex items-center justify-between mb-medium">
                        <div class="flex items-center">
                            <button class="show-filters-button flex items-center" aria-label="Show search filters" style="min-width: 48px; min-height: 48px; padding: 12px;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="width: 20px" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                                </svg>
                                <span class="ml-2">Filters</span>
                            </button>
                            <h2>Define your search criteria</h2>
                        </div>

                        <div>
                            <label for="sort-dropdown" class="sr-only">Sort results by</label>
                            <select id="sort-dropdown" class="sort-dropdown" aria-label="Sort search results" style="min-height: 48px; padding: 12px;">
                                <option value="">Order By</option>
                            <option value="price">Price Asc</option>
                            <option value="-price">Price Desc</option>
                            <option value="year">Year Asc</option>
                            <option value="-year">Year Desc</option>
                            <option value="mileage">Mileage Asc</option>
                            <option value="-mileage">Mileage Desc</option>
                            <option value="created_at">Newest First</option>
                            <option value="-created_at">Oldest First</option>
                        </select>
                        </div>
                    </div>
                    <div class="search-car-results-wrapper">
                        <div class="search-cars-sidebar">
                            <div class="card card-found-cars">
                                <p class="m-0">Found <strong>{{ $cars->total() }}</strong> cars</p>

                                <button class="close-filters-button" aria-label="Close filters" style="min-width: 48px; min-height: 48px; padding: 12px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        style="width: 24px" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Find a car form -->
                            <section class="find-a-car">
                                <form action="" method="GET" class="find-a-car-form card flex p-medium">
                                    <div class="find-a-car-inputs">
                                        <div class="form-group">
                                            <label for="makerSelect" class="mb-medium">Manufacturer</label>
                                            <select id="makerSelect" name="maker_id" aria-label="Select car manufacturer">
                                                <option value="" style="display: block">Manufacturer</option>
                                                <x-select-maker :value="request('maker_id')" />
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="modelSelect" class="mb-medium">Model</label>
                                            <select id="modelSelect" name="model_id" aria-label="Select car model">
                                                <option value="" style="display: block">Model</option>
                                                <x-select-model :value="request('model_id')" />
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="car_type_id" class="mb-medium">Car Type</label>
                                            <select id="car_type_id" name="car_type_id" aria-label="Select car type">
                                                <option value="">Type</option>
                                                <x-select-car-type :value="request('car_type_id')" />
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="year_from" class="mb-medium">Year</label>
                                            <div class="flex gap-1">
                                                <input id="year_from" type="number" placeholder="Year From" name="year_from"
                                                    value="{{ request('year_from') }}" aria-label="Year from" />
                                                <input id="year_to" type="number" placeholder="Year To" name="year_to"
                                                    value="{{ request('year_to') }}" aria-label="Year to" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="price_from" class="mb-medium">Price</label>
                                            <div class="flex gap-1">
                                                <input id="price_from" type="number" placeholder="Price From" name="price_from"
                                                    value="{{ request('price_from') }}" aria-label="Price from" />
                                                <input id="price_to" type="number" placeholder="Price To" name="price_to"
                                                    value="{{ request('price_to') }}" aria-label="Price to" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="mileage" class="mb-medium">Mileage</label>
                                            <div class="flex gap-1">
                                                <select id="mileage" name="mileage" aria-label="Select maximum mileage">
                                                    <option value="">Any Mileage</option>
                                                    <x-select-mileage :value="request('mileage')" />
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="stateSelect" class="mb-medium">State</label>
                                            <select id="stateSelect" name="state_id" aria-label="Select state">
                                                <option value="" style="display: block">State</option>
                                                <x-select-state :value="request('state_id')" />
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="citySelect" class="mb-medium">City</label>
                                            <select id="citySelect" name="city_id" aria-label="Select city">
                                                <option value="" style="display: block">City</option>
                                                <x-select-city :value="request('city_id')" />
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fuel_type_id" class="mb-medium">Fuel Type</label>
                                            <select id="fuel_type_id" name="fuel_type_id" aria-label="Select fuel type">
                                                <option value="">Fuel Type</option>
                                                <x-select-fuel-type :value="request('fuel_type_id')" />
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <button type="button" class="btn btn-find-a-car-reset" aria-label="Reset all search filters" style="min-height: 48px; padding: 12px 16px;">
                                            Reset
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-find-a-car-submit" aria-label="Search for cars with selected filters" style="min-height: 48px; padding: 12px 16px;">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </section>
                            <!--/ Find a car form -->
                        </div>

                        <!-- Search Results -->
                        <div class="search-cars-results">
                            <div class="car-items-listing ">
                                @if ($cars->total() > 0)
                                    @foreach ($cars as $car)
                                        <!-- Car Item Card -->
                                        <x-car-items :$car :$car :in-watchlist="$car->favoredUsers->contains(
                                            \Illuminate\Support\Facades\Auth::user())" />
                                        <!--/ Car Item Card -->
                                    @endforeach
                                @else
                                    <div class="text-center p-large">
                                        <h3>No results found</h3>
                                        <p>Try to change your search criteria.</p>
                                    </div>
                                @endif
                                <!-- Pagination -->
                                {{ $cars->onEachSide(2)->links() }}

                            </div>
                        </div>
                    </div>
            </section>
            <!--/ Found Cars -->
        </main>
    </div>
</x-app>
