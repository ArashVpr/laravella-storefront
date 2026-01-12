<section class="find-a-car">
    <div class="container">
        <h2 class="sr-only">Search for cars</h2>
        <form action="{{ route('car.search') }}" method="GET" class="find-a-car-form card flex p-medium" role="search"
            aria-label="Search for cars">
            <div class="find-a-car-inputs">
                {{-- Enhanced Text Search Input --}}
                <div style="grid-column: span 3; position: relative;">
                    <label for="searchQuery" class="sr-only">Search</label>
                    <div style="position: relative;">
                        <svg style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #6b7280; pointer-events: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text"
                            placeholder="Search by make, model, year, or keyword..."
                            name="q"
                            id="searchQuery"
                            value="{{ request('q') }}"
                            aria-label="Search cars"
                            style="width: 100%; padding-left: 42px; font-size: 15px; border: 2px solid #e5e7eb; border-radius: 8px; transition: all 0.2s;"
                            onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)'"
                            onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none'" />
                    </div>
                </div>
                <div>
                    <label for="makerSelect" class="sr-only">Manufacturer</label>
                    <select id="makerSelect" name="maker_id" aria-label="Select car manufacturer" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="">🏭 {{ __('Manufacturer') }}</option>
                        {{-- manufacturers from database --}}
                        <x-select-maker />
                    </select>
                </div>
                <div>
                    <label for="modelSelect" class="sr-only">Model</label>
                    <select id="modelSelect" name="model_id" aria-label="Select car model" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="" style="display: block">🚗 {{ __('Model') }}</option>
                        {{-- models from database --}}
                        <x-select-model />
                    </select>
                </div>
                <div>
                    <label for="stateSelect" class="sr-only">State/Region</label>
                    <select id="stateSelect" name="state_id" aria-label="Select state or region" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="">📍 {{ __('State/Region') }}</option>
                        {{-- states from database --}}
                        <x-select-state />
                    </select>
                </div>
                <div>
                    <label for="citySelect" class="sr-only">City</label>
                    <select id="citySelect" name="city_id" aria-label="Select city" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="" style="display: block">🏙️ {{ __('City') }}</option>
                        {{-- cities from database --}}
                        <x-select-city />
                    </select>
                </div>
                <div>
                    <label for="carTypeSelect" class="sr-only">Car Type</label>
                    <select name="car_type_id" id="carTypeSelect" aria-label="Select car type" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="">🚙 {{ __('Car Type') }}</option>
                        {{-- car types from database --}}
                        <x-select-car-type />
                    </select>
                </div>
                <div>
                    <label for="yearFrom" class="sr-only">Year From</label>
                    <input type="number" placeholder="📅 {{ __('Year From') }}" name="year_from" id="yearFrom" value="{{ request('year_from') }}"
                        aria-label="Minimum year" style="border-radius: 8px; border: 2px solid #e5e7eb;" />
                </div>
                <div>
                    <label for="yearTo" class="sr-only">Year To</label>
                    <input type="number" placeholder="📅 {{ __('Year To') }}" name="year_to" id="yearTo" value="{{ request('year_to') }}"
                        aria-label="Maximum year" style="border-radius: 8px; border: 2px solid #e5e7eb;" />
                </div>
                <div>
                    <label for="priceFrom" class="sr-only">Price From</label>
                    <input type="number" placeholder="💰 {{ __('Min Price') }}" name="price_from" id="priceFrom" value="{{ request('price_from') }}"
                        aria-label="Minimum price" style="border-radius: 8px; border: 2px solid #e5e7eb;" />
                </div>
                <div>
                    <label for="priceTo" class="sr-only">Price To</label>
                    <input type="number" placeholder="💰 {{ __('Max Price') }}" name="price_to" id="priceTo" value="{{ request('price_to') }}"
                        aria-label="Maximum price" style="border-radius: 8px; border: 2px solid #e5e7eb;" />
                </div>
                <div>
                    <label for="fuelTypeSelect" class="sr-only">Fuel Type</label>
                    <select name="fuel_type_id" id="fuelTypeSelect" aria-label="Select fuel type" style="border-radius: 8px; border: 2px solid #e5e7eb;">
                        <option value="">⛽ {{ __('Fuel Type') }}</option>
                        {{-- fuel types from database --}}
                        <x-select-fuel-type />
                    </select>
                </div>
                <div class="flex flex-col" style="gap: 8px;">
                    <button type="button"
                        class="btn btn-find-a-car-reset"
                        aria-label="Reset search form"
                        style="background: #f3f4f6; color: #374151; border: 2px solid #e5e7eb; border-radius: 8px; padding: 10px 20px; font-weight: 600; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 6px;"
                        onmouseover="this.style.background='#e5e7eb'"
                        onmouseout="this.style.background='#f3f4f6'"
                        onclick="window.location.href='{{ route('car.search') }}'">
                        <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('Reset') }}
                    </button>
                    <button type="submit"
                        class="btn btn-primary btn-find-a-car-submit"
                        aria-label="Search for cars"
                        style="background: #f97316; color: white; border: 2px solid #f97316; border-radius: 8px; padding: 12px 24px; font-weight: 700; font-size: 16px; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.3);"
                        onmouseover="this.style.background='#ea580c'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 8px -1px rgba(249, 115, 22, 0.4)'"
                        onmouseout="this.style.background='#f97316'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(249, 115, 22, 0.3)'">
                        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        {{ __('Search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>