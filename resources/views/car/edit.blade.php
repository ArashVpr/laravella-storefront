<x-app title="Edit Car" bodyClass="bg-gray-50">
    <div class="min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-5xl">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('homepage') }}" class="hover:text-primary">Home</a>
                    <span>/</span>
                    <a href="{{ route('car.index') }}" class="hover:text-primary">My Cars</a>
                    <span>/</span>
                    <span class="text-gray-900 font-medium">Edit Car</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">Edit Car</h1>
                <p class="text-gray-600 mt-2">Update your car listing: {{ $car->getTitle() }}</p>
            </div>

            <form action="{{ route('car.update', $car) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Basic Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Basic Information
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Manufacturer *</label>
                                    <select id="makerSelect" name="maker_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('maker_id') border-red-500 @enderror">
                                        <option value="">Select Manufacturer</option>
                                        <x-select-maker :value="old('maker_id', $car->maker_id)" />
                                    </select>
                                    @error('maker_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Model *</label>
                                    <select id="modelSelect" name="model_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('model_id') border-red-500 @enderror">
                                        <option value="">Select Model</option>
                                        <x-select-model :value="old('model_id', $car->model_id)" />
                                    </select>
                                    @error('model_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Year *</label>
                                    <x-select-year :value="old('year', $car->year)" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" />
                                    @error('year')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Car Type *</label>
                                    <select name="car_type_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('car_type_id') border-red-500 @enderror">
                                        <option value="">Select Type</option>
                                        <x-select-car-type :value="old('car_type_id', $car->car_type_id)" />
                                    </select>
                                    @error('car_type_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Price (USD) *</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                        <input type="number" name="price" value="{{ old('price', $car->price) }}" placeholder="24,500" class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('price') border-red-500 @enderror" />
                                    </div>
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Mileage (miles) *</label>
                                    <input type="number" name="mileage" value="{{ old('mileage', $car->mileage) }}" placeholder="45,000" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('mileage') border-red-500 @enderror" />
                                    @error('mileage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fuel Type *</label>
                                    <select name="fuel_type_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('fuel_type_id') border-red-500 @enderror">
                                        <option value="">Select Fuel</option>
                                        <x-select-fuel-type :value="old('fuel_type_id', $car->fuel_type_id)" />
                                    </select>
                                    @error('fuel_type_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">VIN Code</label>
                                    <input type="text" name="vin" value="{{ old('vin', $car->vin) }}" placeholder="1HGBH41JXMN109186" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('vin') border-red-500 @enderror" />
                                    @error('vin')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Location & Contact
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">State/Region *</label>
                                    <select id="stateSelect" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        <option value="">Select State</option>
                                        <x-select-state :value="old('state_id', $car->city->state_id ?? null)" />
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">City *</label>
                                    <select id="citySelect" name="city_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('city_id') border-red-500 @enderror">
                                        <option value="">Select City</option>
                                        <x-select-city :value="old('city_id', $car->city_id)" />
                                    </select>
                                    @error('city_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                                    <input type="text" name="address" value="{{ old('address', $car->address) }}" placeholder="123 Main Street" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('address') border-red-500 @enderror" />
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $car->phone) }}" placeholder="+1 (555) 000-0000" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('phone') border-red-500 @enderror" />
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Features & Options
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <x-checkbox-car-features :$car />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                Description *
                            </h2>
                            <textarea name="description" rows="8" placeholder="Describe your car's condition, service history, and any additional details buyers should know..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none @error('description') border-red-500 @enderror">{{ old('description', $car->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Sidebar - Image Management -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Photos
                            </h2>

                            @if($car->images->count() > 0)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-3">{{ $car->images->count() }} photo{{ $car->images->count() > 1 ? 's' : '' }} uploaded</p>
                                    <div class="grid grid-cols-2 gap-2 mb-4">
                                        @foreach($car->images->take(4) as $image)
                                            <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                                <img src="{{ $image->getUrl() }}" alt="Car photo" class="w-full h-full object-cover">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-3">No photos uploaded</p>
                                    <div class="aspect-square rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Publish Date</label>
                                <input type="date" name="published_at" value="{{ old('published_at', $car->published_at) }}" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('published_at') border-red-500 @enderror" />
                                @error('published_at')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <a href="{{ route('car.images', $car) }}" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-semibold transition-all shadow-lg shadow-primary/30 mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Manage Photos
                            </a>

                            <div class="pt-6 border-t border-gray-100">
                                <div class="flex gap-3">
                                    <a href="{{ route('car.show', $car) }}" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-all text-center">
                                        Cancel
                                    </a>
                                    <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold transition-all shadow-lg shadow-primary/30">
                                        Update Car
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app>
