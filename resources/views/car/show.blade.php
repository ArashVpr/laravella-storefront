@php
    use Illuminate\Support\Str;

    $inWatchlist = $car->favoredUsers->contains(\Illuminate\Support\Facades\Auth::user());

    $imgs = $car->images->pluck('path')->map(fn($p) => asset('storage/'.$p))->all();
    if (empty($imgs)) {
        $imgs = [asset('img/placeholder-car.jpg')];
    }

    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => "{$car->year} {$car->maker->name} {$car->model->name}",
        'brand' => [
            '@type' => 'Brand',
            'name' => $car->maker->name,
        ],
        'model' => $car->model->name,
        'vehicleModelDate' => (string) $car->year,
        'description' => Str::limit(trim(preg_replace('/\s+/', ' ', $car->description ?? '')), 300, ''),
        'sku' => $car->vin ?? (string) $car->id,
        'image' => $imgs,
        'url' => url()->current(),
        'category' => 'vehicle',
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'EUR',
            'price' => number_format((float)$car->price, 2, '.', ''), // string is fine
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/UsedCondition',
            'url' => url()->current(),
        ],
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>


<x-app title="Car Details">
    <div>
        <main>
            <div class="container">
                <h1 class="car-details-page-title">{{ $car->maker->name }} {{ $car->model->name }} - {{ $car->year }}
                </h1>
                <div class="car-details-region">{{ $car->city->name }} - {{ $car->created_at->format('Y/m/d') }}</div>

                <div class="car-details-content">
                    <div class="car-images-and-description">
                        <div class="car-images-carousel">
                            <div class="car-image-wrapper">
                                <img src="{{ $car->primaryImage?->getUrl() ?? '/img/no-image.png' }}" alt=""
                                    class="car-active-image" id="activeImage" />
                            </div>
                            <div class="car-image-thumbnails">
                                @foreach ($car->images as $image)
                                    <img src="{{ $image->getUrl() }}" alt="" />
                                @endforeach
                            </div>
                            <button class="carousel-button prev-button" id="prevButton">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="width: 64px">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                            </button>
                            <button class="carousel-button next-button" id="nextButton">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="width: 64px">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        </div>

                        <div class="card car-detailed-description">
                            <h2 class="car-details-title">Detailed Description</h2>
                            <p>
                                {{ $car->description }}
                            </p>
                        </div>

                        <div class="card car-detailed-description">
                            <h2 class="car-details-title">Car Specifications</h2>
                            <ul class="car-specifications">

                                <x-car-features :value="$car->features->abs">ABS</x-car-features>
                                <x-car-features :value="$car->features->air_conditioning">Air Conditioning</x-car-features>
                                <x-car-features :value="$car->features->power_windows">Power Windows</x-car-features>
                                <x-car-features :value="$car->features->power_door_locks">Power Door Lock</x-car-features>
                                <x-car-features :value="$car->features->cruise_control">Cruise Control</x-car-features>
                                <x-car-features :value="$car->features->bluetooth_connectivity">Bluetooth</x-car-features>
                                <x-car-features :value="$car->features->gps_navigation">GPS Navigation</x-car-features>
                                <x-car-features :value="$car->features->heated_seats">Heated Seats</x-car-features>
                                <x-car-features :value="$car->features->climate_control">Climate Control</x-car-features>
                                <x-car-features :value="$car->features->rear_parking_sensors">Rear Parking Sensors</x-car-features>
                                <x-car-features :value="$car->features->leather_seats">Leather Seats</x-car-features>

                            </ul>
                        </div>
                    </div>
                    <div class="car-details card">
                        {{-- Featured Badge --}}
                        @if($car->isFeatured())
                            <div class="mb-4 p-3 bg-gradient-to-r from-orange-50 to-yellow-50 border-2 border-orange-300 rounded-lg">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="font-bold text-orange-600 uppercase tracking-wide">Featured Listing</span>
                                    <svg class="h-5 w-5 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <p class="text-center text-orange-700 text-xs mt-1">
                                    Featured until {{ $car->featured_until->format('M d, Y') }}
                                </p>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <p class="car-details-price">${{ number_format($car->price) }}</p>
                            <button class="btn-heart text-primary"
                                data-url="{{ route('watchlist.storeDestroy', $car) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" style="width: 20px"
                                    @class(['hidden' => $inWatchlist])>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>

                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    style="width: 20px" @class(['hidden' => !$inWatchlist])>
                                    <path
                                        d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                                </svg>
                            </button>
                        </div>

                        <hr />

                        {{-- Make Featured Button (Owner Only) --}}
                        @auth
                            @if($car->user_id === auth()->id() && !$car->isFeatured())
                                <div class="my-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <div class="flex items-start space-x-3">
                                        <svg class="h-6 w-6 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Boost Your Listing!</h3>
                                            <p class="text-sm text-gray-600 mb-3">
                                                Get more visibility with a featured listing. Your car will appear at the top of search results with a special badge for {{ config('stripe.featured_listing.duration_days') }} days.
                                            </p>
                                            <div class="flex items-center justify-between">
                                                <span class="text-2xl font-bold text-gray-900">
                                                    ${{ number_format(config('stripe.featured_listing.price') / 100, 2) }}
                                                </span>
                                                <form action="{{ route('stripe.checkout', $car) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors shadow-md hover:shadow-lg">
                                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                        Make Featured
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth

                        <table class="car-details-table">
                            <tbody>
                                <tr>
                                    <th>Maker</th>
                                    <td>{{ $car->maker->name }}</td>
                                </tr>
                                <tr>
                                    <th>Model</th>
                                    <td>{{ $car->model->name }}</td>
                                </tr>
                                <tr>
                                    <th>Year</th>
                                    <td>{{ $car->year }}</td>
                                </tr>
                                <tr>
                                    <th>Car Type</th>
                                    <td>{{ $car->carType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Fuel Type</th>
                                    <td>{{ $car->fuelType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Mileage</th>
                                    <td>{{ $car->mileage }}</td>
                                </tr>
                                <tr>
                                    <th>Vin</th>
                                    <td>{{ $car->vin }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $car->address }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <hr />

                        <div class="flex gap-1 my-medium">
                            <img src="/img/avatar.png" alt="" class="car-details-owner-image" />
                            <div>
                                <h3 class="car-details-owner">{{ $car->owner->name }}</h3>
                                <div class="text-muted">{{ $car->owner->cars()->count() }}</div>
                            </div>
                        </div>
                        <a href="tel:{{ Str::mask($car->phone, '*', -3) }}" class="car-details-phone">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" style="width: 16px">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                            </svg>

                            <span class="text-phone">
                                {{ \Illuminate\Support\Str::mask($car->phone, '*', -3) }}
                            </span>
                            <span class="car-details-phone-view" data-url="{{ route('car.showPhone', $car) }}">view
                                full number</span>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app>
