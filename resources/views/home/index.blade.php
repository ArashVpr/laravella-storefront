<x-app title="Laravella Storefront - Premium Cars">
    <!-- Immersive Hero Section -->
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden bg-gray-900 rounded-b-[2.5rem]">
        <!-- Background Video -->
        <div class="absolute inset-0 z-0">
            <video autoplay muted playsinline class="w-full h-full object-cover opacity-40 scale-105">
                <source src="{{ asset('hero-video.mp4') }}" type="video/mp4">
                <!-- Fallback image if video doesn't load -->
                <img src="/img/car-png-39071.webp" alt="Hero Background" class="w-full h-full object-cover opacity-40 scale-105 animate-pulse-slow">
            </video>
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
        </div>

        <div class="container relative z-10 px-4 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur border border-white/20 text-white text-xs font-semibold tracking-wider uppercase mb-6 animate-fade-in-up">
                The Future of Car Buying
            </span>
            <h1 class="text-5xl md:text-7xl font-black text-white tracking-tight mb-8 leading-tight animate-fade-in-up delay-100">
                Find Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-400 to-primary-600">Dream Ride</span> <br class="hidden md:block" /> Without The Hassle.
            </h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-2xl mx-auto mb-12 animate-fade-in-up delay-200">
                Browse thousands of premium pre-owned vehicles. verified sellers, transparent pricing, and instant financing options.
            </p>

            <!-- Quick Action Box -->
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-2 rounded-full max-w-lg mx-auto flex items-center animate-fade-in-up delay-300">
                <a href="{{ route('car.search') }}" class="flex-1 text-left pl-6 text-gray-300 hover:text-white transition-colors">
                    Search by make, model, or price...
                </a>
                <a href="{{ route('car.search') }}" class="bg-primary hover:bg-primary-hover text-white rounded-full p-3 px-8 font-bold transition-transform hover:scale-105 shadow-lg shadow-primary/30">
                    Search
                </a>
            </div>
            
            <div class="mt-12 flex justify-center gap-8 text-gray-400 text-sm font-medium animate-fade-in-up delay-400">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Verified Dealers
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Instant Approval
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Section (Horizontal Scroll) -->
    @if($featuredCars->count() > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Premium Selections</h2>
                    <p class="text-gray-500">Hand-picked vehicles just for you.</p>
                </div>
                <a href="{{ route('car.search') }}" class="hidden md:flex items-center gap-2 text-primary font-semibold hover:text-primary-700 transition-colors">
                    View Collection
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            <!-- Horizontal Snap Scroll Container -->
            <div class="flex overflow-x-auto gap-6 pb-8 -mx-4 px-4 snap-x hide-scroll-bar">
                @foreach ($featuredCars as $car)
                <div class="min-w-[85vw] md:min-w-[350px] snap-center">
                    <x-car-items :$car :in-watchlist="$car->favoredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Latest Arrivals Grid -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-primary font-semibold tracking-wider uppercase text-sm">Fresh Inventory</span>
                <h2 class="text-4xl font-bold text-gray-900 mt-2 mb-4">Latest Arrivals</h2>
                <p class="text-gray-500">Browse the freshest cars added to our inventory today.</p>
            </div>

            <!-- We'll assume x-new-cars is just a grid wrapper, but let's inline a better grid here if x-new-cars relies on old CSS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                 @foreach($cars as $car)
                    <x-car-items :$car :in-watchlist="$car->favoredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
                 @endforeach
            </div>
            
            <div class="mt-16 text-center">
                <a href="{{ route('car.search') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-base font-medium rounded-full text-white bg-gray-900 hover:bg-gray-800 md:text-lg transition-all shadow-lg hover:shadow-xl">
                    Explore All Inventory
                </a>
            </div>
        </div>
    </section>
</x-app>
