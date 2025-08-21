<header class="navbar" role="banner">
    <div class="container navbar-content">
        <a href="/" class="logo-wrapper" aria-label="CarHub - Go to homepage">
            <img src="/img/carhub-logo.svg" alt="CarHub Logo" />
        </a>
        <button class="btn btn-default btn-navbar-toggle" aria-label="Toggle navigation menu" aria-expanded="false"
            aria-controls="navbar-menu">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 24px" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <nav class="navbar-auth" id="navbar-menu" role="navigation" aria-label="Main navigation">
            {{-- documentation button --}}
            <a href="{{ route('docs') }}" class="btn btn-add-new-car" aria-label="View project documentation">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="margin-right: 4px" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                Documentation
            </a>

            {{-- add new car button --}}
            <a href="{{ route('car.create') }}" class="btn btn-add-new-car" aria-label="Add a new car listing">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" style="width: 18px; margin-right: 4px" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>

                Add new Car
            </a>

            @auth
                <div class="navbar-menu" tabindex="0" role="menu">
                    <button class="navbar-menu-handler" aria-expanded="false" aria-haspopup="true"
                        aria-controls="user-submenu">
                        Welcome, {{ auth()->user()->name }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 20px" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <ul class="submenu" id="user-submenu" role="menu">
                        <li role="none">
                            <a href="{{ route('profile.index') }}" role="menuitem">My Profile</a>
                        </li>
                        <li role="none">
                            <a href="{{ route('car.index') }}" role="menuitem">My Cars</a>
                        </li>
                        <li role="none">
                            <a href="{{ route('watchlist.index') }}" role="menuitem">My Watchlist</a>
                        </li>
                        <li role="none">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" role="menuitem" aria-label="Logout from your account">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endauth
            @guest
                <a href="{{ route('signup') }}" class="btn btn-primary btn-signup" aria-label="Create a new account">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" style="width: 18px; margin-right: 4px" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>

                    Signup
                </a>
                <a href="{{ route('login') }}" class="btn btn-login flex items-center" aria-label="Login to your account">
                    <svg style="width: 18px; fill: currentColor; margin-right: 4px" viewBox="0 0 1024 1024" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path
                            d="M426.666667 736V597.333333H128v-170.666666h298.666667V288L650.666667 512 426.666667 736M341.333333 85.333333h384a85.333333 85.333333 0 0 1 85.333334 85.333334v682.666666a85.333333 85.333333 0 0 1-85.333334 85.333334H341.333333a85.333333 85.333333 0 0 1-85.333333-85.333334v-170.666666h85.333333v170.666666h384V170.666667H341.333333v170.666666H256V170.666667a85.333333 85.333333 0 0 1 85.333333-85.333334z"
                            fill="" />
                    </svg>
                    Login
                </a>
            @endguest
        </nav>
    </div>
</header>
