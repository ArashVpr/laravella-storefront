@props(['car', 'inWatchlist' => false])

<div class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full transform hover:-translate-y-1 overflow-hidden">
    {{-- Featured Badge --}}
    @if($car->isFeatured())
        <div class="absolute top-3 left-3 z-10 bg-black/80 backdrop-blur text-white px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
            <svg class="h-3 w-3 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            <span class="text-[10px] font-bold uppercase tracking-wider">Premium</span>
        </div>
    @endif

    <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
        <a href="{{ route('car.show', $car) }}" aria-label="View details for {{ $car->getTitle() }}">
            @if($car->primaryImage)
                <img src="{{ $car->primaryImage->getUrl() }}" 
                     alt="{{ $car->getTitle() }}" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            @endif
        </a>

        <!-- Watchlist Button -->
        <button data-url="{{ route('watchlist.storeDestroy', $car) }}"
                class="watchlist-btn absolute top-3 right-3 p-2 rounded-full bg-white/90 backdrop-blur transition-colors shadow-sm z-20 {{ $inWatchlist ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}"
                aria-label="{{ $inWatchlist ? 'Remove from watchlist' : 'Add to watchlist' }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"
                 fill="{{ $inWatchlist ? 'currentColor' : 'none' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </button>

        <!-- Hover Overlay -->
        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
             <div class="text-white text-xs font-medium">{{ $car->city->name }}, {{ $car->city->state->name }}</div>
        </div>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-2">
            <span class="text-xs font-semibold tracking-wide uppercase text-primary-600 bg-primary-50 px-2.5 py-0.5 rounded-full border border-primary-100">
                {{ $car->year }}
            </span>
            <span class="text-xs text-gray-400">{{ $car->created_at->diffForHumans(null, true) }}</span>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-tight line-clamp-1 group-hover:text-primary transition-colors">
            <a href="{{ route('car.show', $car) }}">
                {{ $car->getTitle() }}
            </a>
        </h3>

        <div class="flex items-baseline gap-1 mb-4">
             <span class="text-xl font-bold text-gray-900">${{ number_format($car->price) }}</span>
        </div>

        <div class="mt-auto pt-4 border-t border-gray-100 grid grid-cols-2 gap-y-2 text-sm text-gray-500">
             <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span class="truncate">{{ $car->fuelType->name }}</span>
            </div>
            <div class="flex items-center gap-1.5 justify-end">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <span class="truncate">{{ $car->formatted_mileage }}</span>
            </div>
        </div>
    </div>
</div>
