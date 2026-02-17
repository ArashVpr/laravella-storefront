<header x-data="{ open: false }" class="sticky top-0 z-50 w-full backdrop-blur-md bg-white/80 border-b border-gray-100 transition-all duration-300" role="banner">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="/" class="flex-shrink-0 transition-opacity hover:opacity-80" aria-label="CarHub - Go to homepage">
            <img src="/img/carhub-logo.svg" alt="CarHub Logo" class="h-8" />
        </a>

        <!-- Mobile Menu Button -->
        <button @click="open = !open" :aria-expanded="open" class="md:hidden p-2 text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/20 btn-navbar-toggle"
            aria-label="Toggle navigation menu"
            aria-controls="navbar-menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Navigation (mobile friendly) -->
        <nav id="navbar-menu"
            :class="open ? 'fixed inset-x-0 top-[64px] bg-white/95 backdrop-blur-xl border-t border-gray-100 shadow-xl z-40 transition-all duration-300 ease-in-out transform origin-top' : 'hidden md:flex items-center gap-6'"
            role="navigation" aria-label="Main navigation">

            <div class="max-w-7xl mx-auto px-6 py-6 space-y-6 md:hidden h-[calc(100vh-64px)] overflow-y-auto">

                @include('components.dropdown')

                <a href="{{ route('car.create') }}" class="flex items-center justify-center w-full px-4 py-3.5 bg-gray-900 text-white rounded-2xl font-semibold shadow-lg shadow-gray-200 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Sell Your Car') }}
                </a>

                <div class="border-t border-gray-100 pt-6 space-y-4">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">{{ __('My Account') }}</div>
                    @auth
                    <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ auth()->user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                    <a href="{{ route('profile.index') }}" class="flex items-center px-2 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Profile') }}
                    </a>
                    <a href="{{ route('car.index') }}" class="flex items-center px-2 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                        </svg>
                        {{ __('My Cars') }}
                    </a>
                    <a href="{{ route('watchlist.index') }}" class="flex items-center px-2 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        {{ __('Watchlist') }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="mt-2 pt-2 border-t border-gray-50">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-2 py-2 text-red-600 hover:text-red-700 font-medium rounded-lg hover:bg-red-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="flex items-center px-2 py-2 text-gray-600 hover:text-gray-900 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm2.5 7.5a.5.5 0 100-1 .5.5 0 000 1zM9 13v-1a4 4 0 014-4h6v2h-6a2 2 0 00-2 2v1h-2zm5-10v5h-2V3h2z" clip-rule="evenodd" /> <!-- Just a placeholder icon if needed, using login specific one is better -->
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('signup') }}" class="flex items-center justify-center w-full mt-3 px-4 py-3 bg-primary text-white rounded-xl font-semibold shadow-sm hover:shadow-md transition-all">
                        {{ __('Sign up for Free') }}
                    </a>
                    @endauth
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">{{ __('Language') }}</div>
                    <div class="flex gap-3">
                        <a href="{{ route('locale.switch', 'en') }}" class="flex-1 flex items-center justify-center px-3 py-2.5 rounded-xl border {{ App::getLocale() == 'en' ? 'border-primary bg-primary/5 text-primary font-medium' : 'border-gray-200 text-gray-600 hover:border-gray-300' }} transition-colors">
                            <span class="mr-2 text-lg">🇺🇸</span> English
                        </a>
                        <a href="{{ route('locale.switch', 'fr') }}" class="flex-1 flex items-center justify-center px-3 py-2.5 rounded-xl border {{ App::getLocale() == 'fr' ? 'border-primary bg-primary/5 text-primary font-medium' : 'border-gray-200 text-gray-600 hover:border-gray-300' }} transition-colors">
                            <span class="mr-2 text-lg">🇫🇷</span> Français
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        @auth
        <div class="relative group hidden md:flex" tabindex="0" role="menu">
            <button class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none"
                aria-expanded="false"
                aria-haspopup="true"
                aria-controls="user-submenu">
                <span class="text-gray-500 font-normal">{{ __('Welcome,') }}</span> {{ auth()->user()->name }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right">
                <ul class="py-1" id="user-submenu" role="menu">
                    <li role="none">
                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">{{ __('My Profile') }}</a>
                    </li>
                    <li role="none">
                        <a href="{{ route('car.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">{{ __('My Cars') }}</a>
                    </li>
                    <li role="none">
                        <a href="{{ route('watchlist.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors" role="menuitem">{{ __('My Watchlist') }}</a>
                    </li>
                    <li role="none" class="border-t border-gray-100 mt-1 pt-1">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors" role="menuitem" aria-label="Logout from your account">{{ __('Log Out') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        @endauth

        @guest
        <div class="hidden md:flex items-center gap-3">
            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors" aria-label="Login to your account">
                {{ __('Log in') }}
            </a>

            <a href="{{ route('signup') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-full hover:bg-primary-hover shadow-sm hover:shadow-md transition-all duration-200" aria-label="Create a new account">
                {{ __('Sign up') }}
            </a>
        </div>
        @endguest
        </nav>
    </div>
</header>