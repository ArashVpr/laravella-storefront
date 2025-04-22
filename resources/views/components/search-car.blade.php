<section class="find-a-car">
    <div class="container">
      <form
        action="{{ route('car.search') }}"
        method="GET"
        class="find-a-car-form card flex p-medium"
      >
        <div class="find-a-car-inputs">
          <div>
            <select id="makerSelect" name="maker_id">
              <option value="">Manufacturer</option>
              {{-- manufacturers from database --}}
              <x-select-maker />
            </select>
          </div>
          <div>
            <select id="modelSelect" name="model_id">
              <option value="" style="display: block">Model</option>
              {{-- models from database --}}
              <x-select-model />
            </select>
          </div>
          <div>
            <select id="stateSelect" name="state_id">
              <option value="">State/Region</option>
              {{-- states from database --}}
              <x-select-state />
            </select>
          </div>
          <div>
            <select id="citySelect" name="city_id">
              <option value="" style="display: block">City</option>
              {{-- cities from database --}}
              <x-select-city />
            </select>
          </div>
          <div>
            <select name="car_type_id">
              <option value="">Car Type</option>
              {{-- car types from database --}}
              <x-select-car-type />
            </select>
          </div>
          <div>
            <input type="number" placeholder="Year From" name="year_from" />
          </div>
          <div>
            <input type="number" placeholder="Year To" name="year_to" />
          </div>
          <div>
            <input
              type="number"
              placeholder="Price From"
              name="price_from"
            />
          </div>
          <div>
            <input type="number" placeholder="Price To" name="price_to" />
          </div>
          <div>
            <select name="fuel_type_id">
              <option value="">Fuel Type</option>
              {{-- fuel types from database --}}
              <x-select-fuel-type />
            </select>
          </div>
        </div>
        <div>
          <button type="button" class="btn btn-find-a-car-reset">
            Reset
          </button>
          <button class="btn btn-primary btn-find-a-car-submit">
            Search
          </button>
        </div>
      </form>
    </div>
  </section>