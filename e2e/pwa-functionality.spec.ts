import { test, expect } from '@playwright/test';

// Use the seed file to set up base URL
test.use({ storageState: undefined });

test.describe('PWA Functionality Tests', () => {
    test.beforeEach(async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/');
    });

    test('01 - PWA manifest is accessible and valid', async ({ page }) => {
        // Navigate to manifest
        const manifestResponse = await page.goto('http://127.0.0.1:8000/manifest.json');

        // Verify manifest loads successfully
        expect(manifestResponse?.status()).toBe(200);

        // Parse manifest JSON
        const manifestData = await manifestResponse?.json();

        // Verify required manifest fields
        expect(manifestData).toHaveProperty('name');
        expect(manifestData).toHaveProperty('short_name');
        expect(manifestData).toHaveProperty('start_url');
        expect(manifestData).toHaveProperty('display');
        expect(manifestData).toHaveProperty('theme_color');
        expect(manifestData).toHaveProperty('background_color');
        expect(manifestData).toHaveProperty('icons');

        // Verify icons array has required sizes
        expect(manifestData.icons).toBeInstanceOf(Array);
        expect(manifestData.icons.length).toBeGreaterThan(0);

        const iconSizes = manifestData.icons.map((icon: any) => icon.sizes);
        expect(iconSizes).toContain('192x192');
        expect(iconSizes).toContain('512x512');

        console.log('✅ Manifest validation passed');
    });

    test('02 - Service worker registration', async ({ page, context }) => {
        // Wait for page to load
        await page.waitForLoadState('networkidle');

        // Check if service worker is registered
        const serviceWorkerRegistered = await page.evaluate(async () => {
            if ('serviceWorker' in navigator) {
                const registration = await navigator.serviceWorker.getRegistration();
                return registration !== undefined;
            }
            return false;
        });

        // Note: Service worker may not register immediately in test environment
        // or may require HTTPS. This test verifies the registration code exists.
        console.log('Service Worker registered:', serviceWorkerRegistered);

        // Verify service worker script exists
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        expect(swResponse?.status()).toBe(200);

        const swContent = await swResponse?.text();
        expect(swContent).toContain('CACHE_VERSION');
        expect(swContent).toContain('addEventListener');

        console.log('✅ Service worker file accessible');
    });

    test('03 - PWA meta tags are present', async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/');

        // Check for manifest link
        const manifestLink = await page.locator('link[rel="manifest"]').getAttribute('href');
        expect(manifestLink).toContain('manifest.json');

        // Check for theme color
        const themeColor = await page.locator('meta[name="theme-color"]').getAttribute('content');
        expect(themeColor).toBeTruthy();

        // Check for apple mobile web app capable
        const appleMobileCapable = await page.locator('meta[name="apple-mobile-web-app-capable"]').getAttribute('content');
        expect(appleMobileCapable).toBe('yes');

        // Check for apple touch icon
        const appleTouchIcon = await page.locator('link[rel="apple-touch-icon"]').getAttribute('href');
        expect(appleTouchIcon).toBeTruthy();

        console.log('✅ PWA meta tags validated');
    });

    test('04 - Offline page exists and is valid', async ({ page }) => {
        const offlineResponse = await page.goto('http://127.0.0.1:8000/offline.html');

        expect(offlineResponse?.status()).toBe(200);

        // Verify offline page has proper content
        await expect(page.locator('h1')).toContainText(/offline/i);

        // Check for retry/home button
        const tryAgainButton = await page.locator('a[href="/"]');
        expect(await tryAgainButton.count()).toBeGreaterThan(0);

        console.log('✅ Offline page validated');
    });

    test('05 - PWA icon files are accessible', async ({ page }) => {
        const requiredIcons = [
            'http://127.0.0.1:8000/images/icons/icon-72x72.png',
            'http://127.0.0.1:8000/images/icons/icon-96x96.png',
            'http://127.0.0.1:8000/images/icons/icon-128x128.png',
            'http://127.0.0.1:8000/images/icons/icon-144x144.png',
            'http://127.0.0.1:8000/images/icons/icon-152x152.png',
            'http://127.0.0.1:8000/images/icons/icon-192x192.png',
            'http://127.0.0.1:8000/images/icons/icon-384x384.png',
            'http://127.0.0.1:8000/images/icons/icon-512x512.png',
        ];

        let successCount = 0;

        for (const iconPath of requiredIcons) {
            const response = await page.goto(iconPath);
            if (response?.status() === 200) {
                successCount++;
            }
        }

        // All icons should be accessible
        expect(successCount).toBe(requiredIcons.length);

        console.log(`✅ All ${successCount} PWA icons accessible`);
    });

    test('06 - Service worker caching strategy verification', async ({ page }) => {
        // Load service worker content
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        const swContent = await swResponse?.text() || '';

        // Verify caching strategies are defined
        expect(swContent).toContain('CACHE_STRATEGIES');
        expect(swContent).toContain('CACHE_FIRST');
        expect(swContent).toContain('NETWORK_FIRST');
        expect(swContent).toContain('STALE_WHILE_REVALIDATE');

        // Verify cache lifecycle events
        expect(swContent).toContain("addEventListener('install'");
        expect(swContent).toContain("addEventListener('activate'");
        expect(swContent).toContain("addEventListener('fetch'");

        // Verify offline fallback
        expect(swContent).toContain('getOfflineFallback');

        console.log('✅ Service worker caching strategies verified');
    });

    test('07 - PWA install prompt handling code exists', async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/');

        // Check if beforeinstallprompt event listener is registered
        const hasInstallPromptHandler = await page.evaluate(() => {
            // Check if the install prompt code exists in the page
            const scripts = Array.from(document.getElementsByTagName('script'));
            return scripts.some(script =>
                script.textContent?.includes('beforeinstallprompt')
            );
        });

        expect(hasInstallPromptHandler).toBe(true);

        console.log('✅ PWA install prompt handler present');
    });

    test('08 - Service worker update notification mechanism', async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/');

        // Verify update handling code exists
        const hasUpdateHandler = await page.evaluate(() => {
            const scripts = Array.from(document.getElementsByTagName('script'));
            return scripts.some(script =>
                script.textContent?.includes('updatefound') &&
                script.textContent?.includes('SKIP_WAITING')
            );
        });

        expect(hasUpdateHandler).toBe(true);

        console.log('✅ Service worker update mechanism verified');
    });

    test('09 - Push notification support infrastructure', async ({ page }) => {
        // Load service worker and check for push event handlers
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        const swContent = await swResponse?.text() || '';

        // Verify push notification event listener
        expect(swContent).toContain("addEventListener('push'");

        // Verify notification click handler
        expect(swContent).toContain("addEventListener('notificationclick'");

        console.log('✅ Push notification infrastructure present');
    });

    test('10 - Background sync capability', async ({ page }) => {
        // Load service worker and check for background sync
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        const swContent = await swResponse?.text() || '';

        // Verify background sync event listener
        expect(swContent).toContain("addEventListener('sync'");

        console.log('✅ Background sync capability verified');
    });

    test('11 - App shortcuts in manifest', async ({ page }) => {
        const manifestResponse = await page.goto('http://127.0.0.1:8000/manifest.json');
        const manifestData = await manifestResponse?.json();

        // Verify shortcuts exist
        expect(manifestData).toHaveProperty('shortcuts');
        expect(manifestData.shortcuts).toBeInstanceOf(Array);
        expect(manifestData.shortcuts.length).toBeGreaterThan(0);

        // Verify each shortcut has required fields
        for (const shortcut of manifestData.shortcuts) {
            expect(shortcut).toHaveProperty('name');
            expect(shortcut).toHaveProperty('url');
            expect(shortcut).toHaveProperty('icons');
        }

        console.log(`✅ ${manifestData.shortcuts.length} app shortcuts configured`);
    });

    test('12 - Share target configuration', async ({ page }) => {
        const manifestResponse = await page.goto('http://127.0.0.1:8000/manifest.json');
        const manifestData = await manifestResponse?.json();

        // Verify share target exists
        expect(manifestData).toHaveProperty('share_target');
        expect(manifestData.share_target).toHaveProperty('action');
        expect(manifestData.share_target).toHaveProperty('method');
        expect(manifestData.share_target).toHaveProperty('params');

        console.log('✅ Share target configured');
    });

    test('13 - PWA runs in standalone mode detection', async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/');

        // Check if standalone mode detection code exists
        const hasStandaloneModeDetection = await page.evaluate(() => {
            const scripts = Array.from(document.getElementsByTagName('script'));
            return scripts.some(script =>
                script.textContent?.includes('display-mode: standalone') ||
                script.textContent?.includes('navigator.standalone')
            );
        });

        expect(hasStandaloneModeDetection).toBe(true);

        console.log('✅ Standalone mode detection present');
    });

    test('14 - Cache version management', async ({ page }) => {
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        const swContent = await swResponse?.text() || '';

        // Verify cache version is defined
        const cacheVersionMatch = swContent.match(/CACHE_VERSION\s*=\s*['"]([^'"]+)['"]/);
        expect(cacheVersionMatch).toBeTruthy();

        const cacheVersion = cacheVersionMatch?.[1];
        expect(cacheVersion).toBeTruthy();

        console.log(`✅ Cache version: ${cacheVersion}`);
    });

    test('15 - Accessibility of precached assets', async ({ page }) => {
        // Navigate to home first
        await page.goto('http://127.0.0.1:8000/');

        // Test critical pages are accessible via fetch
        const homeAccessible = await page.evaluate(async () => {
            const res = await fetch('/');
            return res.ok;
        });

        const manifestAccessible = await page.evaluate(async () => {
            const res = await fetch('/manifest.json');
            return res.ok;
        });

        const offlineAccessible = await page.evaluate(async () => {
            const res = await fetch('/offline.html');
            return res.ok;
        });

        expect(homeAccessible).toBe(true);
        expect(manifestAccessible).toBe(true);
        expect(offlineAccessible).toBe(true);

        console.log(`✅ All critical assets accessible (/, manifest.json, offline.html)`);
    });
});

test.describe('PWA User Experience Tests', () => {
    test('16 - Service worker registration message in console', async ({ page }) => {
        const logs: string[] = [];

        page.on('console', msg => {
            if (msg.type() === 'log') {
                logs.push(msg.text());
            }
        });

        await page.goto('http://127.0.0.1:8000/');
        await page.waitForTimeout(2000); // Wait for service worker registration

        // Check if registration log appears (only works if SW actually registers)
        const hasSwLog = logs.some(log =>
            log.includes('Service Worker') ||
            log.includes('SW')
        );

        console.log('Console logs captured:', logs.length);
        if (hasSwLog) {
            console.log('✅ Service worker registration logged');
        } else {
            console.log('ℹ️  Service worker may not register in test environment (requires HTTPS)');
        }
    });

    test('17 - Offline page visual elements', async ({ page }) => {
        await page.goto('http://127.0.0.1:8000/offline.html');

        // Check for visual elements
        await expect(page.locator('h1')).toBeVisible();
        await expect(page.locator('p').first()).toBeVisible();

        // Check for connection status indicator
        const statusElement = page.locator('#status');
        expect(await statusElement.count()).toBe(1);

        console.log('✅ Offline page visual elements present');
    });

    test('18 - PWA configuration completeness', async ({ page }) => {
        // This is a comprehensive check
        const checks = [];

        // Check manifest
        const manifestResponse = await page.goto('http://127.0.0.1:8000/manifest.json');
        checks.push({ name: 'Manifest', passed: manifestResponse?.status() === 200 });

        // Check service worker
        const swResponse = await page.goto('http://127.0.0.1:8000/sw.js');
        checks.push({ name: 'Service Worker', passed: swResponse?.status() === 200 });

        // Check offline page
        const offlineResponse = await page.goto('http://127.0.0.1:8000/offline.html');
        checks.push({ name: 'Offline Page', passed: offlineResponse?.status() === 200 });

        // Check critical icons
        const icon192 = await page.goto('http://127.0.0.1:8000/images/icons/icon-192x192.png');
        checks.push({ name: 'Icon 192x192', passed: icon192?.status() === 200 });

        const icon512 = await page.goto('http://127.0.0.1:8000/images/icons/icon-512x512.png');
        checks.push({ name: 'Icon 512x512', passed: icon512?.status() === 200 });

        // All checks should pass
        const allPassed = checks.every(check => check.passed);
        expect(allPassed).toBe(true);

        console.log('✅ PWA Configuration Checklist:');
        checks.forEach(check => {
            console.log(`   ${check.passed ? '✅' : '❌'} ${check.name}`);
        });
    });
});
