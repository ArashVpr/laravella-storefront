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
                                        <select>
                                            <option value="">Manufacturer</option>
                                            <x-select-maker />
                                        </select>
                                        <p class="error-message">This field is required</p>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Model</label>
                                        <select>
                                            <option value="">Model</option>
                                            <x-select-model />
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Year</label>
                                        <select>
                                            <option value="">Year</option>
                                            <option value="2024">2024</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                            <option value="2020">2020</option>
                                            <option value="2019">2019</option>
                                            <option value="2018">2018</option>
                                            <option value="2017">2017</option>
                                            <option value="2016">2016</option>
                                            <option value="2015">2015</option>
                                            <option value="2014">2014</option>
                                            <option value="2013">2013</option>
                                            <option value="2012">2012</option>
                                            <option value="2011">2011</option>
                                            <option value="2010">2010</option>
                                            <option value="2009">2009</option>
                                            <option value="2008">2008</option>
                                            <option value="2007">2007</option>
                                            <option value="2006">2006</option>
                                            <option value="2005">2005</option>
                                            <option value="2004">2004</option>
                                            <option value="2003">2003</option>
                                            <option value="2002">2002</option>
                                            <option value="2001">2001</option>
                                            <option value="2000">2000</option>
                                            <option value="1999">1999</option>
                                            <option value="1998">1998</option>
                                            <option value="1997">1997</option>
                                            <option value="1996">1996</option>
                                            <option value="1995">1995</option>
                                            <option value="1994">1994</option>
                                            <option value="1993">1993</option>
                                            <option value="1992">1992</option>
                                            <option value="1991">1991</option>
                                            <option value="1990">1990</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Car Type</label>
                                <div class="row">
                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="car_type" value="sedan" />
                                            Sedan
                                        </label>
                                    </div>

                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="car_type" value="hatchback" />
                                            Hatchback
                                        </label>
                                    </div>

                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="car_type" value="suv" />
                                            SUV (Sport Utility Vehicle)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" placeholder="Price" name+="price" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Vin Code</label>
                                        <input placeholder="Vin Code" name="vin_code" />
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
                                        <label class="inline-radio">
                                            <input type="radio" name="fuel_type" value="gasoline" />
                                            Gasoline
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="fuel_type" value="diesel" />
                                            Diesel
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="fuel_type" value="electric" />
                                            Electric
                                        </label>
                                    </div>
                                    <div class="col">
                                        <label class="inline-radio">
                                            <input type="radio" name="fuel_type" value="hybrid" />
                                            Hybrid
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>State/Region</label>
                                        <select>
                                            <option value="">State/Region</option>
                                            <x-select-state />
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>City</label>
                                        <select>
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
                                <label>Detailed Description</label>
                                <input type="date" name="created_at" />
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
