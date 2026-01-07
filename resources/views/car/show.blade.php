@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Storage;

    $inWatchlist = Auth::check() && $car->favoredUsers->contains(Auth::user());

    $imgs = $car->images->pluck('path')->map(fn($p) => asset('storage/'.$p))->all();
    if (empty($imgs)) {
        $imgs = [asset('img/placeholder-car.jpg')];
    }
    
    // SEO Data
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => "{$car->year} {$car->maker->name} {$car->model->name}",
        'brand' => ['@type' => 'Brand', 'name' => $car->maker->name],
        'model' => $car->model->name,
        'image' => $imgs,
        'description' => Str::limit(trim(preg_replace('/\s+/', ' ', $car->description ?? '')), 300),
        'offers' => [
            '@type' => 'Offer',
            'priceCurrency' => 'USD',
            'price' => $car->price,
            'availability' => 'https://schema.org/InStock',
        ]
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>

<x-app title="{{ $car->maker->name }} {{ $car->model->name }}" bodyClass="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col pb-20">
        <!-- Breadcrumb & Header -->
        <div class="bg-white border-b border-gray-200 sticky top-16 z-20 shadow-sm transition-all duration-200">
            <div class="container mx-auto px-4 py-4 md:py-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="text-sm text-gray-500 mb-1 flex items-center gap-2">
                             <a href="{{ route('homepage') }}" class="hover:text-primary">Home</a> / 
                             <a href="{{ route('car.search') }}" class="hover:text-primary">Search</a> / 
                             <span class="text-gray-900 font-medium">{{ $car->maker->name }}</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight">
                            {{ $car->maker->name }} {{ $car->model->name }} <span class="text-gray-400 font-normal ml-2 text-xl">{{ $car->year }}</span>
                        </h1>
                        <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                             <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                             {{ $car->city->name }}, {{ $car->city->state->name }}
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                         <div class="text-right">
                             <p class="text-xs text-gray-500 uppercase font-semibold">Price</p>
                             <p class="text-3xl font-bold text-primary">${{ number_format($car->price) }}</p>
                         </div>
                         <!-- Watchlist Button -->
                         <button data-url="{{ route('watchlist.storeDestroy', $car) }}" 
                                 class="watchlist-btn p-3 rounded-full bg-gray-100 hover:bg-red-50 transition-colors {{ $inWatchlist ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500' }}" 
                                 title="{{ $inWatchlist ? 'Remove from Watchlist' : 'Add to Watchlist' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="{{ $inWatchlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                         </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 flex-grow">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content (Gallery + Details) -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Gallery -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 p-2">
                        <div x-data="{ activeImage: '{{ $car->primaryImage ? $car->primaryImage->getUrl() : asset('img/no-image.png') }}' }">
                            <div class="relative w-full bg-gray-100 rounded-xl overflow-hidden mb-2 group" style="aspect-ratio: 16/9;">
                                <img :src="activeImage" alt="{{ $car->maker->name }} {{ $car->model->name }}" class="object-cover w-full h-full transition-all duration-300">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors pointer-events-none"></div>
                            </div>
                            <!-- Thumbnails -->
                            @if($car->images->count() > 1)
                            <div class="grid grid-cols-5 gap-2">
                                @foreach($car->images as $image)
                                    <button @click="activeImage = '{{ $image->getUrl() }}'" class="relative rounded-lg overflow-hidden border-2 border-transparent hover:border-primary focus:border-primary focus:outline-none transition-all" style="aspect-ratio: 1/1;">
                                        <img src="{{ $image->getUrl() }}" alt="Thumbnail" class="object-cover w-full h-full">
                                    </button>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-2">Vehicle Overview</h2>
                        <div class="prose prose-orange max-w-none text-gray-600">
                            {!! nl2br(e($car->description)) !!}
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Features & Options</h2>
                        <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <x-car-features :value="$car->features?->abs ?? false">ABS</x-car-features>
                            <x-car-features :value="$car->features?->air_conditioning ?? false">Air Conditioning</x-car-features>
                            <x-car-features :value="$car->features?->power_windows ?? false">Power Windows</x-car-features>
                            <x-car-features :value="$car->features?->power_door_locks ?? false">Power Locks</x-car-features>
                            <x-car-features :value="$car->features?->cruise_control ?? false">Cruise Control</x-car-features>
                            <x-car-features :value="$car->features?->bluetooth_connectivity ?? false">Bluetooth</x-car-features>
                            <x-car-features :value="$car->features?->gps_navigation ?? false">Navigation</x-car-features>
                            <x-car-features :value="$car->features?->heated_seats ?? false">Heated Seats</x-car-features>
                            <x-car-features :value="$car->features?->climate_control ?? false">Climate Control</x-car-features>
                            <x-car-features :value="$car->features?->rear_parking_sensors ?? false">Parking Sensors</x-car-features>
                            <x-car-features :value="$car->features?->leather_seats ?? false">Leather Seats</x-car-features>
                        </ul>
                    </div>
                </div>

                <!-- Sticky Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Seller Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-36">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary font-bold text-xl">
                                {{ substr($car->user?->name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Listed by</p>
                                <h3 class="font-bold text-gray-900">{{ $car->user?->name ?? 'Unknown Seller' }}</h3>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <form action="{{ route('car.showPhone', $car) }}" method="POST">
                                @csrf
                                <button class="w-full flex items-center justify-center gap-2 bg-primary hover:bg-primary-hover text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg shadow-primary/30">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    Show Phone Number
                                </button>
                            </form>
                            
                            <a href="mailto:{{ $car->user?->email }}" class="w-full flex items-center justify-center gap-2 bg-white border-2 border-gray-200 hover:border-primary hover:text-primary text-gray-700 font-bold py-3 px-4 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Message Seller
                            </a>
                        </div>
                        
                        <div class="mt-6 pt-6 border-t border-gray-100">
                             <h4 class="font-semibold text-gray-900 mb-2">Safety Tips</h4>
                             <ul class="text-xs text-gray-500 space-y-1 list-disc pl-4">
                                 <li>Inspect the car in person</li>
                                 <li>Check vehicle history report</li>
                                 <li>Meet in a safe public place</li>
                             </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app>
