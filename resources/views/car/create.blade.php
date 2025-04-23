<x-app title="Add New Car">
    <div>
        <main>
            <div class="container-small">
                <h1 class="car-details-page-title">Add new car</h1>
                <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data"
                    class="card add-new-car-form">
                    @csrf
                    <div class="form-content">
                        <div class="form-details">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Manufacturer</label>
                                        <select id="makerSelect" name="maker_id">
                                            <option value="">Manufacturer</option>
                                            <x-select-maker />
                                        </select>
                                        <p class="error-message">This field is required</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <select id="modelSelect" name="model_id">
                                            <option value="">Model</option>
                                            <x-select-model />
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Year</label>
                                        <x-select-year />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Car Type</label>
                                <div class="row">
                                    <div class="col">
                                        <x-select-radio-car-type />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" placeholder="Price" name="price" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Vin Code</label>
                                        <input placeholder="Vin Code" name="vin" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Mileage (ml)</label>
                                        <input placeholder="Mileage" name="mileage" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fuel Type</label>
                                <div class="row">
                                    <div class="col">
                                        <x-select-radio-fuel-type />
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>State/Region</label>
                                        <select id="stateSelect">
                                            <option value="">State/Region</option>
                                            <x-select-state />
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select id="citySelect" name="city_id">
                                            <option value="">City</option>
                                            <x-select-city />
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input placeholder="Address" name="address" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input placeholder="Phone" name="phone" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col grid grid-cols-2">
                                        <x-checkbox-car-features />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Detailed Description</label>
                                <textarea rows="10" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Publish Date</label>
                                <input type="date" name="published_at" />
                                </label>
                            </div>
                        </div>
                        <div class="form-images">
                            <div class="form-image-upload">
                                <div class="upload-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" style="width: 48px">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <input id="carFormImageUpload" type="file" multiple />
                            </div>
                            <div id="imagePreviews" class="car-form-images"></div>
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
