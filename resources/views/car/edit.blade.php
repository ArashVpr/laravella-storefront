<x-app title="Edit Car">
    <div>
        <main>
            <div class="container-small">
                <h1 class="car-details-page-title">Edit Car: {{ $car->getTitle() }}</h1>
                <form action="{{ route('car.update', $car) }}" method="POST" class="card add-new-car-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-content">
                        <div class="form-details">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group @error('maker_id') has-error @enderror">
                                        <label>Manufacturer</label>
                                        <select id="makerSelect" name="maker_id">
                                            <option value="">Manufacturer</option>
                                            <x-select-maker :value="old('maker_id', $car->maker_id)" />
                                        </select>
                                        <p class="error-message">{{ $errors->first('maker_id') }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('model_id') has-error @enderror">
                                        <label>Model</label>
                                        <select id="modelSelect" name="model_id">
                                            <option value="">Model</option>
                                            <x-select-model :value="old('model_id', $car->model_id)" />
                                        </select>
                                        <p class="error-message">{{ $errors->first('model_id') }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('year') has-error @enderror">
                                        <label>Year</label>
                                        <x-select-year :value="old('year', $car->year)" />
                                        <p class="error-message">{{ $errors->first('year') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group @error('car_type_id') has-error @enderror">
                                <label>Car Type</label>
                                <div class="row">
                                    <div class="col">
                                        <x-select-radio-car-type :value="old('car_type_id', $car->car_type_id)" />
                                    </div>
                                </div>
                                <p class="error-message">{{ $errors->first('car_type_id') }}</p>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group @error('price') has-error @enderror">
                                        <label>Price</label>
                                        <input type="number" placeholder="Price" name="price"
                                            value="{{ old('price', $car->price) }}" />
                                        <p class="error-message">{{ $errors->first('price') }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('vin') has-error @enderror">
                                        <label>Vin Code</label>
                                        <input placeholder="Vin Code" name="vin"
                                            value="{{ old('vin', $car->vin) }}" />
                                        <p class="error-message">{{ $errors->first('vin') }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('mileage') has-error @enderror">
                                        <label>Mileage (ml)</label>
                                        <input placeholder="Mileage" name="mileage"
                                            value="{{ old('mileage', $car->mileage) }}" />
                                        <p class="error-message">{{ $errors->first('mileage') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group @error('fuel_type_id') has-error @enderror">
                                <label>Fuel Type</label>
                                <div class="row">
                                    <div class="col">
                                        <x-select-radio-fuel-type :value="old('fuel_type_id', $car->fuel_type_id)" />
                                    </div>
                                </div>
                                <p class="error-message">{{ $errors->first('fuel_type_id') }}</p>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>State/Region</label>
                                        <select id="stateSelect">
                                            <option value="">State/Region</option>
                                            <x-select-state :value="old('state_id', $car->city->state_id)" />
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('city_id') has-error @enderror">
                                        <label>City</label>
                                        <select id="citySelect" name="city_id">
                                            <option value="">City</option>
                                            <x-select-city :value="old('city_id', $car->city_id)" />
                                        </select>
                                        <p class="error-message">{{ $errors->first('city_id') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group @error('address') has-error @enderror">
                                        <label>Address</label>
                                        <input placeholder="Address" name="address"
                                            value="{{ old('address', $car->address) }}" />
                                        <p class="error-message">{{ $errors->first('address') }}</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group @error('phone') has-error @enderror">
                                        <label>Phone</label>
                                        <input placeholder="Phone" name="phone"
                                            value="{{ old('phone', $car->phone) }}" />
                                        <p class="error-message">{{ $errors->first('phone') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col grid grid-cols-2">
                                        <x-checkbox-car-features :$car />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group @error('description') has-error @enderror">
                                <label>Detailed Description</label>
                                <textarea rows="10" name="description">{{ old('description', $car->description) }}</textarea>
                                <p class="error-message">{{ $errors->first('description') }}</p>
                            </div>

                            <div class="form-group @error('published_at') has-error @enderror">
                                <label>Publish Date</label>
                                <input type="date" name="published_at"
                                    value="{{ old('published_at', $car->published_at) }}" />
                                <p class="error-message">
                                    {{ $errors->first('published_at') }}
                                </p>
                                </label>
                            </div>
                        </div>
                        <div class="form-images">
                            <p> Manage your images <a href="{{ route('car.images', $car) }}">here</a></p>
                            <div id="imagePreviews" class="car-form-images">
                                @foreach ($car->images as $image)
                                    <div class="car-form-image-preview">
                                        <img src="{{ $image->getUrl() }}" alt="">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="p-medium" style="width: 100%">
                        <div class="flex justify-end gap-1">
                            <button type="button" class="btn btn-default">Reset</button>
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

</x-app>
