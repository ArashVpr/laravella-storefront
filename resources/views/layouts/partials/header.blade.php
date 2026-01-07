<header class="sticky top-0 z-50 w-full backdrop-blur-md bg-white/80 border-b border-gray-100 transition-all duration-300" role="banner">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="flex-shrink-0 transition-opacity hover:opacity-80" aria-label="CarHub - Go to homepage">
            <img src="/img/carhub-logo.svg" alt="CarHub Logo" class="h-8" />
        </a>

        <!-- Mobile Menu Button -->
        <button class="md:hidden p-2 text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/20 btn-navbar-toggle" 
                aria-label="Toggle navigation menu"
                aria-expanded="false"
                aria-controls="navbar-menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Navigation -->
        <nav id="navbar-menu" class="hidden md:flex items-center gap-6" role="navigation" aria-label="Main navigation">
            {{-- Documentation Dropdown Blade Component --}}
            @include('components.dropdown')

            {{-- Add new car button --}}
            <a href="{{ route('car.create') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-full hover:bg-gray-800 transition-colors duration-200" 
               aria-label="Add a new car listing">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Sell Your Car
            </a>

            @auth
                <div class="relative group" tabindex="0" role="menu">
                    <button class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none" 
                            aria-expanded="false" 
                            aria-haspopup="true"
                            aria-controls="user-submenu">
                        <span class="text-gray-500 font-normal">Welcome,</span> {{ auth()->user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                        <ul class="py-1" id="user-submenu" role="menu">
                            <li role="none">
                                <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">My Profile</a>
                            </li>
                            <li role="none">
                                <a href="{{ route('car.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">My Cars</a>
                            </li>
                            <li role="none">
                                <a href="{{ route('watchlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">My Watchlist</a>
                            </li>
                            <li role="none" class="border-t border-gray-100 mt-1 pt-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem" aria-label="Logout from your account">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth

            @guest
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors" aria-label="Login to your account">
                        Log in
                    </a>
                    
                    <a href="{{ route('signup') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-full hover:bg-primary-hover shadow-sm hover:shadow-md transition-all duration-200" aria-label="Create a new account">
                        Sign up
                    </a>
                </div>
            @endguest
        </nav>
    </div>
</header>
