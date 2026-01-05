<x-app title="Home Page">
    {{-- @session('success')
        <div class="container my-large">
            <div class="success-message">
                {{ session('success') }}
            </div>
        </div>
    @endsession --}}
    <!-- Home Slider -->
    <x-hero-slider />
    <!--/ Home Slider -->
    <main>
        <!-- Find a car form -->
        <x-search-car />
        <!--/ Find a car form -->

        <!-- Featured Cars -->
        @if($featuredCars->count() > 0)
            <section class="bg-gradient-to-b from-orange-50 to-transparent py-12">
                <div class="container">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <svg class="h-8 w-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <h2 class="text-3xl font-bold text-gray-900">Featured Listings</h2>
                        </div>
                        <span class="text-sm text-gray-600 bg-white px-3 py-1 rounded-full shadow-sm">Premium picks</span>
                    </div>
                    <div class="car-items-listing">
                        @foreach ($featuredCars as $car)
                            <x-car-items :$car :in-watchlist="$car->favoredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!--/ Featured Cars -->

        <!-- New Cars -->
        <x-new-cars :$cars />
        <!--/ New Cars -->
    </main>
</x-app>