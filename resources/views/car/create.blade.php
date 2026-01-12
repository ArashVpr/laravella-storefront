<x-app title="{{ __('Add New Car') }}" bodyClass="bg-gray-50">
    <div class="min-h-screen py-12">
        <div class="container mx-auto px-4 max-w-5xl">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                    <a href="{{ route('homepage') }}" class="hover:text-primary">{{ __('Home') }}</a>
                    <span>/</span>
                    <span class="text-gray-900 font-medium">{{ __('Sell Your Car') }}</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight">{{ __('List Your Car') }}</h1>
                <p class="text-gray-600 mt-2">{{ __('Fill in the details below to create your car listing') }}</p>
            </div>

            <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Main Form -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Basic Information -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Basic Information') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Manufacturer *') }}</label>
                                    <select id="makerSelect" name="maker_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('maker_id') border-red-500 @enderror">
                                        <option value="">{{ __('Select Manufacturer') }}</option>
                                        <x-select-maker :value="old('maker_id')" />
                                    </select>
                                    @error('maker_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Model *') }}</label>
                                    <select id="modelSelect" name="model_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('model_id') border-red-500 @enderror">
                                        <option value="">{{ __('Select Model') }}</option>
                                        <x-select-model :value="old('model_id')" />
                                    </select>
                                    @error('model_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Year *') }}</label>
                                    <x-select-year :value="old('year')" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all" />
                                    @error('year')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Car Type *') }}</label>
                                    <select name="car_type_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('car_type_id') border-red-500 @enderror">
                                        <option value="">{{ __('Select Type') }}</option>
                                        <x-select-car-type :value="old('car_type_id')" />
                                    </select>
                                    @error('car_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Price (USD) *') }}</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-semibold">$</span>
                                        <input type="number" name="price" value="{{ old('price') }}" placeholder="{{ __('24,500') }}" class="w-full pl-8 pr-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('price') border-red-500 @enderror" />
                                    </div>
                                    @error('price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Mileage (miles) *') }}</label>
                                    <input type="number" name="mileage" value="{{ old('mileage') }}" placeholder="{{ __('45,000') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('mileage') border-red-500 @enderror" />
                                    @error('mileage')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Fuel Type *') }}</label>
                                    <select name="fuel_type_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('fuel_type_id') border-red-500 @enderror">
                                        <option value="">{{ __('Select Fuel') }}</option>
                                        <x-select-fuel-type :value="old('fuel_type_id')" />
                                    </select>
                                    @error('fuel_type_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('VIN Code') }}</label>
                                    <input type="text" name="vin" value="{{ old('vin') }}" placeholder="{{ __('1HGBH41JXMN109186') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('vin') border-red-500 @enderror" />
                                    @error('vin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ __('Location') }}
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('State/Region *') }}</label>
                                    <select id="stateSelect" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        <option value="">{{ __('Select State') }}</option>
                                        <x-select-state :value="old('state_id')" />
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('City *') }}</label>
                                    <select id="citySelect" name="city_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('city_id') border-red-500 @enderror">
                                        <option value="">{{ __('Select City') }}</option>
                                        <x-select-city :value="old('city_id')" />
                                    </select>
                                    @error('city_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Address') }}</label>
                                    <input type="text" name="address" value="{{ old('address') }}" placeholder="{{ __('Street address') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('address') border-red-500 @enderror" />
                                    @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Phone Number *') }}</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="{{ __('+1 (555) 000-0000') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('phone') border-red-500 @enderror" />
                                    @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Features & Options') }}
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <x-checkbox-car-features :value="old('features', [])" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                                {{ __('Description *') }}
                            </h2>
                            <textarea name="description" rows="8" placeholder="{{ __('Describe your car\'s condition, service history, and any additional details buyers should know...') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Publish Date removed (placed in Photos sidebar) -->
                    </div>

                    <!-- Sidebar - Image Upload -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ __('Photos *') }}
                            </h2>
                            <p class="text-sm text-gray-600 mb-4">{{ __('Upload up to 10 images') }}</p>

                            <label for="carFormImageUpload" class="block cursor-pointer">
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary hover:bg-primary/5 transition-all">
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    <p class="text-sm font-semibold text-gray-700">{{ __('Click to upload images') }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ __('PNG, JPG up to 5MB each') }}</p>
                                </div>
                                <input id="carFormImageUpload" type="file" name="images[]" multiple accept="image/*" class="hidden" />
                            </label>

                            <div id="imagePreviews" class="mt-4 space-y-2"></div>

                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">{{ __('Publish Date') }}</label>
                                <input type="date" name="published_at" value="{{ old('published_at') }}" class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('published_at') border-red-500 @enderror" />
                                @error('published_at')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <div class="flex gap-3">
                                    <button type="button" class="flex-1 px-4 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition-all">
                                        {{ __('Reset') }}
                                    </button>
                                    <button type="submit" class="flex-1 px-4 py-3 rounded-xl bg-primary hover:bg-primary-hover text-white font-bold transition-all shadow-lg shadow-primary/30">
                                        {{ __('Publish') }}
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