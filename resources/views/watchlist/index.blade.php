<x-app title="{{ __('Watchlist') }}">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-end mb-8">
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ __('My Watchlist') }}</h1>
            @if ($cars->total() > 0)
            <p class="text-sm text-gray-500 mb-1">
                {{ __('Showing :first-:last of :total cars', ['first' => $cars->firstItem(), 'last' => $cars->lastItem(), 'total' => $cars->total()]) }}
            </p>
            @endif
        </div>

        @if ($cars->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($cars as $car)
            <x-car-items :$car :inWatchlist="true" />
            @endforeach
        </div>

        <div class="mt-8">
            {{ $cars->onEachSide(1)->links() }}
        </div>
        @else
        <div class="text-center py-20 bg-gray-50 rounded-3xl border border-gray-100 border-dashed">
            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400 shadow-sm">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('No favorites yet') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('Start browsing to add cars to your watchlist.') }}</p>
            <a href="{{ route('car.search') }}" class="inline-block bg-primary hover:bg-primary-hover text-white font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-primary/30">
                {{ __('Browse Cars') }}
            </a>
        </div>
        @endif
    </div>
</x-app>