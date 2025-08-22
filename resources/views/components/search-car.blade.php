<section class="find-a-car">
    <div class="container">
        <h2 class="sr-only">Search for cars</h2>
        <form action="{{ route('car.search') }}" method="GET" class="find-a-car-form card flex p-medium" role="search"
            aria-label="Search for cars">
            <div class="find-a-car-inputs">
                <div>
                    <label for="makerSelect" class="sr-only">Manufacturer</label>
                    <select id="makerSelect" name="maker_id" aria-label="Select car manufacturer">
                        <option value="">Manufacturer</option>
                        {{-- manufacturers from database --}}
                        <x-select-maker />
                    </select>
                </div>
                <div>
                    <label for="modelSelect" class="sr-only">Model</label>
                    <select id="modelSelect" name="model_id" aria-label="Select car model">
                        <option value="" style="display: block">Model</option>
                        {{-- models from database --}}
                        <x-select-model />
                    </select>
                </div>
                <div>
                    <label for="stateSelect" class="sr-only">State/Region</label>
                    <select id="stateSelect" name="state_id" aria-label="Select state or region">
                        <option value="">State/Region</option>
                        {{-- states from database --}}
                        <x-select-state />
                    </select>
                </div>
                <div>
                    <label for="citySelect" class="sr-only">City</label>
                    <select id="citySelect" name="city_id" aria-label="Select city">
                        <option value="" style="display: block">City</option>
                        {{-- cities from database --}}
                        <x-select-city />
                    </select>
                </div>
                <div>
                    <label for="carTypeSelect" class="sr-only">Car Type</label>
                    <select name="car_type_id" id="carTypeSelect" aria-label="Select car type">
                        <option value="">Car Type</option>
                        {{-- car types from database --}}
                        <x-select-car-type />
                    </select>
                </div>
                <div>
                    <label for="yearFrom" class="sr-only">Year From</label>
                    <input type="number" placeholder="Year From" name="year_from" id="yearFrom"
                        aria-label="Minimum year" />
                </div>
                <div>
                    <label for="yearTo" class="sr-only">Year To</label>
                    <input type="number" placeholder="Year To" name="year_to" id="yearTo"
                        aria-label="Maximum year" />
                </div>
                <div>
                    <label for="priceFrom" class="sr-only">Price From</label>
                    <input type="number" placeholder="Price From" name="price_from" id="priceFrom"
                        aria-label="Minimum price" />
                </div>
                <div>
                    <label for="priceTo" class="sr-only">Price To</label>
                    <input type="number" placeholder="Price To" name="price_to" id="priceTo"
                        aria-label="Maximum price" />
                </div>
                <div>
                    <label for="fuelTypeSelect" class="sr-only">Fuel Type</label>
                    <select name="fuel_type_id" id="fuelTypeSelect" aria-label="Select fuel type">
                        <option value="">Fuel Type</option>
                        {{-- fuel types from database --}}
                        <x-select-fuel-type />
                    </select>
                </div>
                <div class="flex flex-col">
                    <button type="button" class="btn btn-find-a-car-reset" aria-label="Reset search form">
                        Reset
                    </button>
                    <button type="submit" class="btn btn-primary btn-find-a-car-submit" aria-label="Search for cars">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>
