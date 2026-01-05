// Service Worker for Laravella Storefront PWA
const CACHE_VERSION = 'v1.0.0';
const CACHE_NAME = `laravella-${CACHE_VERSION}`;

// Assets to cache immediately on install
const PRECACHE_ASSETS = [
    '/',
    '/cars',
    '/manifest.json',
    '/css/app.css',
    '/js/app.js',
    '/images/logo.svg',
    '/offline.html'
];

// Cache strategies
const CACHE_STRATEGIES = {
    CACHE_FIRST: 'cache-first',
    NETWORK_FIRST: 'network-first',
    NETWORK_ONLY: 'network-only',
    CACHE_ONLY: 'cache-only',
    STALE_WHILE_REVALIDATE: 'stale-while-revalidate'
};

// URL patterns and their cache strategies
const ROUTES = [
    { pattern: /\.(png|jpg|jpeg|svg|gif|webp|ico)$/, strategy: CACHE_STRATEGIES.CACHE_FIRST, cacheName: 'images' },
    { pattern: /\.(css|js)$/, strategy: CACHE_STRATEGIES.STALE_WHILE_REVALIDATE, cacheName: 'static' },
    { pattern: /\/api\//, strategy: CACHE_STRATEGIES.NETWORK_FIRST, cacheName: 'api' },
    { pattern: /\/cars\/\d+$/, strategy: CACHE_STRATEGIES.NETWORK_FIRST, cacheName: 'pages' },
    { pattern: /\/$/, strategy: CACHE_STRATEGIES.NETWORK_FIRST, cacheName: 'pages' }
];

// Install event - precache critical assets
self.addEventListener('install', (event) => {
    console.log('[SW] Installing service worker...', CACHE_VERSION);

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[SW] Precaching assets');
                return cache.addAll(PRECACHE_ASSETS.map(url => new Request(url, { cache: 'reload' })));
            })
            .then(() => {
                console.log('[SW] Skip waiting');
                return self.skipWaiting();
            })
            .catch((error) => {
                console.error('[SW] Precaching failed:', error);
            })
    );
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    console.log('[SW] Activating service worker...', CACHE_VERSION);

    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name.startsWith('laravella-') && name !== CACHE_NAME)
                        .map((name) => {
                            console.log('[SW] Deleting old cache:', name);
                            return caches.delete(name);
                        })
                );
            })
            .then(() => {
                console.log('[SW] Claiming clients');
                return self.clients.claim();
            })
    );
});

// Fetch event - apply caching strategies
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') {
        return;
    }

    // Skip Chrome extensions
    if (url.protocol === 'chrome-extension:') {
        return;
    }

    // Find matching route strategy
    const route = ROUTES.find(r => r.pattern.test(url.pathname + url.search));

    if (route) {
        event.respondWith(handleRequest(request, route.strategy, route.cacheName));
    } else {
        // Default strategy for unmatched routes
        event.respondWith(handleRequest(request, CACHE_STRATEGIES.NETWORK_FIRST, 'dynamic'));
    }
});

// Handle request based on strategy
async function handleRequest(request, strategy, cacheName) {
    const cache = await caches.open(`${CACHE_NAME}-${cacheName}`);

    switch (strategy) {
        case CACHE_STRATEGIES.CACHE_FIRST:
            return cacheFirst(request, cache);

        case CACHE_STRATEGIES.NETWORK_FIRST:
            return networkFirst(request, cache);

        case CACHE_STRATEGIES.STALE_WHILE_REVALIDATE:
            return staleWhileRevalidate(request, cache);

        case CACHE_STRATEGIES.NETWORK_ONLY:
            return fetch(request);

        case CACHE_STRATEGIES.CACHE_ONLY:
            return cache.match(request);

        default:
            return networkFirst(request, cache);
    }
}

// Cache First Strategy
async function cacheFirst(request, cache) {
    const cached = await cache.match(request);

    if (cached) {
        return cached;
    }

    try {
        const response = await fetch(request);

        if (response.ok) {
            cache.put(request, response.clone());
        }

        return response;
    } catch (error) {
        console.error('[SW] Cache first failed:', error);
        return getOfflineFallback();
    }
}

// Network First Strategy
async function networkFirst(request, cache) {
    try {
        const response = await fetch(request);

        if (response.ok) {
            cache.put(request, response.clone());
        }

        return response;
    } catch (error) {
        console.log('[SW] Network failed, trying cache:', request.url);

        const cached = await cache.match(request);

        if (cached) {
            return cached;
        }

        return getOfflineFallback();
    }
}

// Stale While Revalidate Strategy
async function staleWhileRevalidate(request, cache) {
    const cached = await cache.match(request);

    const fetchPromise = fetch(request)
        .then((response) => {
            if (response.ok) {
                cache.put(request, response.clone());
            }
            return response;
        })
        .catch(() => cached);

    return cached || fetchPromise;
}

// Get offline fallback page
async function getOfflineFallback() {
    const cache = await caches.open(CACHE_NAME);
    const offline = await cache.match('/offline.html');

    if (offline) {
        return offline;
    }

    // Return basic offline response
    return new Response(
        '<html><body><h1>You are offline</h1><p>Please check your internet connection.</p></body></html>',
        {
            headers: { 'Content-Type': 'text/html' }
        }
    );
}

// Background Sync - retry failed requests
self.addEventListener('sync', (event) => {
    console.log('[SW] Background sync:', event.tag);

    if (event.tag === 'sync-forms') {
        event.waitUntil(syncFormSubmissions());
    }
});

async function syncFormSubmissions() {
    // Retrieve pending form submissions from IndexedDB and retry
    console.log('[SW] Syncing form submissions...');
    // Implementation would retrieve from IndexedDB and POST to server
}

// Push Notifications
self.addEventListener('push', (event) => {
    console.log('[SW] Push received:', event);

    const data = event.data ? event.data.json() : {};
    const title = data.title || 'Laravella Notification';
    const options = {
        body: data.body || 'New update available',
        icon: '/images/icons/icon-192x192.png',
        badge: '/images/icons/badge-72x72.png',
        vibrate: [200, 100, 200],
        data: data.url || '/',
        actions: data.actions || [
            { action: 'view', title: 'View' },
            { action: 'close', title: 'Close' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

// Notification Click Handler
self.addEventListener('notificationclick', (event) => {
    console.log('[SW] Notification clicked:', event);

    event.notification.close();

    const url = event.notification.data || '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then((clientList) => {
                // Check if there's already a window open
                for (const client of clientList) {
                    if (client.url === url && 'focus' in client) {
                        return client.focus();
                    }
                }

                // Open new window
                if (clients.openWindow) {
                    return clients.openWindow(url);
                }
            })
    );
});

// Message event - communicate with main thread
self.addEventListener('message', (event) => {
    console.log('[SW] Message received:', event.data);

    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }

    if (event.data && event.data.type === 'CACHE_URLS') {
        event.waitUntil(
            caches.open(CACHE_NAME)
                .then((cache) => cache.addAll(event.data.urls))
        );
    }

    if (event.data && event.data.type === 'CLEAR_CACHE') {
        event.waitUntil(
            caches.keys()
                .then((names) => Promise.all(names.map((name) => caches.delete(name))))
        );
    }
});

console.log('[SW] Service worker loaded', CACHE_VERSION);
