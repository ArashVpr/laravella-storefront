#!/usr/bin/env php
<?php

/**
 * PWA Testing Script
 * Tests manifest, service worker, and offline functionality
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\File;

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n🔍 PWA Implementation Test\n";
echo str_repeat('=', 50) . "\n\n";

$results = [
    'passed' => 0,
    'failed' => 0,
    'warnings' => 0
];

function test($description, $condition, $failMessage = '') {
    global $results;
    
    if ($condition) {
        echo "✅ {$description}\n";
        $results['passed']++;
        return true;
    } else {
        echo "❌ {$description}\n";
        if ($failMessage) {
            echo "   → {$failMessage}\n";
        }
        $results['failed']++;
        return false;
    }
}

function warning($message) {
    global $results;
    echo "⚠️  {$message}\n";
    $results['warnings']++;
}

function section($title) {
    echo "\n📋 {$title}\n";
    echo str_repeat('-', 50) . "\n";
}

// Test 1: Manifest File
section('Manifest File Tests');

$manifestPath = public_path('manifest.json');
test(
    'Manifest file exists',
    file_exists($manifestPath),
    "File not found: {$manifestPath}"
);

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    
    test(
        'Manifest is valid JSON',
        $manifest !== null,
        'Failed to parse manifest.json'
    );
    
    if ($manifest) {
        test('Manifest has name', !empty($manifest['name']));
        test('Manifest has short_name', !empty($manifest['short_name']));
        test('Manifest has start_url', !empty($manifest['start_url']));
        test('Manifest has display mode', !empty($manifest['display']));
        test('Manifest has theme_color', !empty($manifest['theme_color']));
        test('Manifest has background_color', !empty($manifest['background_color']));
        test('Manifest has icons array', is_array($manifest['icons'] ?? null) && count($manifest['icons']) > 0);
        
        // Check icon sizes
        $requiredSizes = ['192x192', '512x512'];
        $iconSizes = array_column($manifest['icons'], 'sizes');
        
        foreach ($requiredSizes as $size) {
            test(
                "Manifest has {$size} icon",
                in_array($size, $iconSizes),
                "Required icon size {$size} not found"
            );
        }
        
        // Advanced features
        if (isset($manifest['shortcuts'])) {
            test('Manifest has app shortcuts', count($manifest['shortcuts']) > 0);
            echo "   Found " . count($manifest['shortcuts']) . " shortcuts\n";
        }
        
        if (isset($manifest['share_target'])) {
            test('Manifest has share target', !empty($manifest['share_target']['action']));
        }
    }
}

// Test 2: Service Worker
section('Service Worker Tests');

$swPath = public_path('sw.js');
test(
    'Service worker file exists',
    file_exists($swPath),
    "File not found: {$swPath}"
);

if (file_exists($swPath)) {
    $swContent = file_get_contents($swPath);
    
    test('Service worker has cache name', str_contains($swContent, 'CACHE_NAME'));
    test('Service worker has install event', str_contains($swContent, "addEventListener('install'"));
    test('Service worker has activate event', str_contains($swContent, "addEventListener('activate'"));
    test('Service worker has fetch event', str_contains($swContent, "addEventListener('fetch'"));
    test('Service worker has cache strategies', str_contains($swContent, 'CACHE_STRATEGIES'));
    test('Service worker has offline fallback', str_contains($swContent, 'getOfflineFallback'));
    
    // Advanced features
    if (str_contains($swContent, "addEventListener('push'")) {
        test('Service worker supports push notifications', true);
    }
    
    if (str_contains($swContent, "addEventListener('sync'")) {
        test('Service worker supports background sync', true);
    }
    
    // Check cache version
    preg_match("/CACHE_VERSION\s*=\s*'([^']+)'/", $swContent, $matches);
    if (isset($matches[1])) {
        echo "   Cache version: {$matches[1]}\n";
    }
}

// Test 3: Offline Page
section('Offline Page Tests');

$offlinePath = public_path('offline.html');
test(
    'Offline page exists',
    file_exists($offlinePath),
    "File not found: {$offlinePath}"
);

if (file_exists($offlinePath)) {
    $offlineContent = file_get_contents($offlinePath);
    
    test('Offline page is valid HTML', str_contains($offlineContent, '<!DOCTYPE html>'));
    test('Offline page has title', str_contains($offlineContent, '<title>'));
    test('Offline page has connection status script', str_contains($offlineContent, 'navigator.onLine'));
    test('Offline page has retry button', str_contains($offlineContent, 'Try Again') || str_contains($offlineContent, 'try again'));
}

// Test 4: Layout Integration
section('Layout Integration Tests');

$basePath = resource_path('views/components/base.blade.php');
test(
    'Base layout file exists',
    file_exists($basePath),
    "File not found: {$basePath}"
);

if (file_exists($basePath)) {
    $layoutContent = file_get_contents($basePath);
    
    test('Layout has manifest link', str_contains($layoutContent, 'manifest.json'));
    test('Layout has service worker registration', str_contains($layoutContent, 'serviceWorker.register'));
    test('Layout has theme-color meta tag', str_contains($layoutContent, 'theme-color'));
    test('Layout has apple-mobile-web-app-capable', str_contains($layoutContent, 'apple-mobile-web-app-capable'));
    test('Layout has install prompt handler', str_contains($layoutContent, 'beforeinstallprompt'));
    
    // Check for PWA mode detection
    if (str_contains($layoutContent, 'display-mode: standalone')) {
        test('Layout detects PWA standalone mode', true);
    }
}

// Test 5: Icon Files Check
section('Icon Files Check');

$iconSizes = ['72x72', '96x96', '128x128', '144x144', '152x152', '192x192', '384x384', '512x512'];
$iconsDir = public_path('images/icons');

if (!is_dir($iconsDir)) {
    warning("Icons directory does not exist: {$iconsDir}");
    warning("You need to generate PWA icons using a tool like https://www.pwabuilder.com/imageGenerator");
} else {
    foreach ($iconSizes as $size) {
        $iconPath = "{$iconsDir}/icon-{$size}.png";
        if (!file_exists($iconPath)) {
            warning("Icon file missing: icon-{$size}.png");
        }
    }
}

// Test 6: Browser Compatibility
section('Browser Compatibility Checks');

if (file_exists($swPath)) {
    $swContent = file_get_contents($swPath);
    
    // Check for modern API usage
    test('Uses async/await syntax', str_contains($swContent, 'async function') || str_contains($swContent, 'async ('));
    test('Uses Promise API', str_contains($swContent, 'Promise'));
    test('Uses fetch API', str_contains($swContent, 'fetch('));
    test('Uses Cache API', str_contains($swContent, 'caches.'));
}

// Test 7: Security & Best Practices
section('Security & Best Practices');

if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    
    if ($manifest) {
        // Check scope
        if (isset($manifest['scope'])) {
            test('Manifest has defined scope', true);
        } else {
            warning('Manifest missing scope - will default to start_url directory');
        }
        
        // Check display mode
        $validDisplayModes = ['fullscreen', 'standalone', 'minimal-ui', 'browser'];
        if (isset($manifest['display'])) {
            test(
                'Valid display mode',
                in_array($manifest['display'], $validDisplayModes),
                "Display mode '{$manifest['display']}' is not standard"
            );
        }
        
        // Check orientation
        if (isset($manifest['orientation'])) {
            $validOrientations = ['any', 'natural', 'landscape', 'portrait', 'portrait-primary', 'portrait-secondary', 'landscape-primary', 'landscape-secondary'];
            test(
                'Valid orientation',
                in_array($manifest['orientation'], $validOrientations),
                "Orientation '{$manifest['orientation']}' is not standard"
            );
        }
    }
}

// Test 8: Lighthouse PWA Criteria
section('Lighthouse PWA Criteria Checklist');

$lighthouseCriteria = [
    'Has web app manifest' => file_exists($manifestPath),
    'Has service worker' => file_exists($swPath),
    'Manifest has name' => isset($manifest['name']),
    'Manifest has icons' => isset($manifest['icons']) && count($manifest['icons']) >= 2,
    'Has theme color' => isset($manifest['theme_color']),
    'Has start_url' => isset($manifest['start_url']),
    'Supports offline mode' => file_exists($offlinePath),
];

foreach ($lighthouseCriteria as $criterion => $result) {
    test($criterion, $result);
}

// Additional recommendations
section('Recommendations');

echo "\n📌 To complete your PWA setup:\n\n";

if (!is_dir($iconsDir) || count(glob("{$iconsDir}/*.png")) < 8) {
    echo "1. Generate PWA icons:\n";
    echo "   - Visit https://www.pwabuilder.com/imageGenerator\n";
    echo "   - Upload a 512x512 PNG logo\n";
    echo "   - Download and extract to public/images/icons/\n\n";
}

echo "2. Test PWA installation:\n";
echo "   - Serve app over HTTPS (required for service workers)\n";
echo "   - Open in Chrome/Edge\n";
echo "   - Look for install prompt in address bar\n";
echo "   - Check Chrome DevTools > Application > Manifest\n\n";

echo "3. Test offline functionality:\n";
echo "   - Install the PWA\n";
echo "   - Open Chrome DevTools > Network\n";
echo "   - Toggle 'Offline' mode\n";
echo "   - Navigate the app - cached pages should work\n\n";

echo "4. Run Lighthouse audit:\n";
echo "   - Chrome DevTools > Lighthouse\n";
echo "   - Select 'Progressive Web App'\n";
echo "   - Generate report\n\n";

echo "5. Test on mobile devices:\n";
echo "   - Android: Chrome > Menu > Install app\n";
echo "   - iOS: Safari > Share > Add to Home Screen\n\n";

// Summary
echo "\n" . str_repeat('=', 50) . "\n";
echo "📊 Test Summary\n";
echo str_repeat('=', 50) . "\n";
echo "✅ Passed:   {$results['passed']}\n";
echo "❌ Failed:   {$results['failed']}\n";
echo "⚠️  Warnings: {$results['warnings']}\n";
echo str_repeat('=', 50) . "\n";

if ($results['failed'] === 0) {
    echo "\n🎉 All critical tests passed! Your PWA is ready.\n";
    exit(0);
} else {
    echo "\n⚠️  Some tests failed. Please fix the issues above.\n";
    exit(1);
}
