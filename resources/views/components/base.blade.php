@props(['bodyClass' => '', 'title' => '', 'metaDescription' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- // CSRF token for security --}}
    <title>{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}</title>

    {{-- SEO Meta Tags --}}
    <meta name="description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}">
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Open Graph Tags --}}
    <meta property="og:title" content="{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}" />
    <meta property="og:description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="{{ asset('img/car-png-39071.webp') }}" />

    {{-- Twitter Card Tags --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title ? $title . ' | ' . config('app.name') : config('app.name') }}" />
    <meta name="twitter:description"
        content="{{ $metaDescription ?? 'car-hub.xyz is a Laravel-based web application for car management, features, authentication, and more.' }}" />
    <meta name="twitter:image" content="{{ asset('img/car-png-39071.webp') }}" />

    {{-- PWA Meta Tags --}}
    <meta name="theme-color" content="#3b82f6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Laravella">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icons/icon-192x192.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- SortableJS for drag-and-drop functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body @if ($bodyClass) class="{{ $bodyClass }}" @endif>
    <!-- Skip to main content link for keyboard users -->
    <a href="#main-content" class="skip-link sr-only focus:not-sr-only">Skip to main content</a>

    {{ $slot }}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollReveal.js/4.0.9/scrollreveal.js"
        integrity="sha512-XJgPMFq31Ren4pKVQgeD+0JTDzn0IwS1802sc+QTZckE6rny7AN2HLReq6Yamwpd2hFe5nJJGZLvPStWFv5Kww=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="https://unpkg.com/website-carbon-badges@1.1.3/b.min.js" defer></script>
    
    {{-- PWA Service Worker Registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('✅ Service Worker registered:', registration.scope);
                        
                        // Check for updates
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            console.log('🔄 Service Worker update found');
                            
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // New service worker available, prompt user to refresh
                                    if (confirm('New version available! Reload to update?')) {
                                        newWorker.postMessage({ type: 'SKIP_WAITING' });
                                        window.location.reload();
                                    }
                                }
                            });
                        });
                    })
                    .catch((error) => {
                        console.error('❌ Service Worker registration failed:', error);
                    });
                
                // Handle service worker controller change
                let refreshing = false;
                navigator.serviceWorker.addEventListener('controllerchange', () => {
                    if (!refreshing) {
                        refreshing = true;
                        window.location.reload();
                    }
                });
            });
        }
        
        // PWA Install Prompt
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Show custom install button if exists
            const installBtn = document.getElementById('pwa-install-btn');
            if (installBtn) {
                installBtn.style.display = 'block';
                installBtn.addEventListener('click', async () => {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        const { outcome } = await deferredPrompt.userChoice;
                        console.log(`User response to install prompt: ${outcome}`);
                        deferredPrompt = null;
                        installBtn.style.display = 'none';
                    }
                });
            }
        });
        
        // Track if app is running as PWA
        window.addEventListener('appinstalled', () => {
            console.log('✅ PWA installed successfully');
            deferredPrompt = null;
        });
        
        // Check if running as PWA
        if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
            console.log('📱 Running as installed PWA');
            document.body.classList.add('pwa-mode');
        }
    </script>
</body>

</html>
