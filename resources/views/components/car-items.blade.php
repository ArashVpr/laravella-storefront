@props(['car', 'inWatchlist' => false])

<div class="car-item card relative">
    {{-- Featured Badge --}}
    @if($car->isFeatured())
        <div class="absolute top-2 left-2 z-10 bg-gradient-to-r from-orange-500 to-yellow-500 text-white px-3 py-1.5 rounded-full shadow-lg flex items-center space-x-1.5">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-xs font-bold uppercase tracking-wide">Featured</span>
        </div>
    @endif

    <a href="{{ route('car.show', $car) }}" aria-label="View details for {{ $car->getTitle() }}">
        <img src={{ $car->primaryImage?->getUrl() ?? '/img/no-image.png' }}
            alt="{{ $car->primaryImage ? $car->getTitle() . ' - Primary car image' : 'No image available for ' . $car->getTitle() }}"
            class="car-item-img rounded-t" />
    </a>
    <div class="p-medium">
        <div class="flex items-center justify-between">
            <small class="m-0 text-muted">{{ $car->city->name }}</small>
            <button class="btn-heart text-primary" data-url="{{ route('watchlist.storeDestroy', $car) }}"
                aria-label="{{ $inWatchlist ? 'Remove ' . $car->getTitle() . ' from watchlist' : 'Add ' . $car->getTitle() . ' to watchlist' }}"
                aria-pressed="{{ $inWatchlist ? 'true' : 'false' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 20px" @class(['hidden' => $inWatchlist]) aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 20px"
                    @class(['hidden' => !$inWatchlist]) aria-hidden="true">
                    <path
                        d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                </svg>
                <span class="sr-only">{{ $inWatchlist ? 'Remove from watchlist' : 'Add to watchlist' }}</span>
            </button>
        </div>
        <h3 class="car-item-title">{{ $car->getTitle() }}</h3>
        <p class="car-item-price">${{ number_format($car->price) }}</p>
        <hr />
        <p class="m-0">
            <span class="car-item-badge">{{ $car->carType->name }}</span>
            <span class="car-item-badge">{{ $car->fuelType->name }}</span>
        </p>
    </div>
</div>
