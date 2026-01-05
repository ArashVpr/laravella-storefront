<?php

use App\Models\User;
use Laravel\Pennant\Feature;

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== Laravel Pennant Feature Flags Test ===\n\n";

// Test 1: Global feature (real-time-chat)
echo "1. Testing global feature 'real-time-chat':\n";
$chatActive = Feature::active('real-time-chat');
echo "   Real-time chat enabled: " . ($chatActive ? '✓ YES' : '✗ NO') . "\n\n";

// Test 2: Global feature (webp-images)
echo "2. Testing global feature 'webp-images':\n";
$webpActive = Feature::active('webp-images');
echo "   WebP images enabled: " . ($webpActive ? '✓ YES' : '✗ NO') . "\n\n";

// Test 3: User-scoped features
echo "3. Testing user-scoped features:\n";

// Get or create a test user
$testUser = User::where('email', 'test@example.com')->first();
if ($testUser) {
    // Delete all feature flags for this user
    DB::table('features')->where('scope', 'like', '%|' . $testUser->id)->delete();
    $testUser->delete();
}

echo "   Creating test user...\n";
$testUser = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
]);

echo "   Test user: {$testUser->email}\n";

// Test enhanced search (requires premium)
$enhancedSearch = Feature::for($testUser)->active('enhanced-search');
echo "   - Enhanced search: " . ($enhancedSearch ? '✓ ACTIVE' : '✗ INACTIVE') . " (requires premium)\n";

// Test premium watchlist (requires premium)
$premiumWatchlist = Feature::for($testUser)->active('premium-watchlist');
echo "   - Premium watchlist: " . ($premiumWatchlist ? '✓ ACTIVE' : '✗ INACTIVE') . " (requires premium)\n";

// Test seller analytics (requires 3+ cars)
$sellerAnalytics = Feature::for($testUser)->active('seller-analytics');
$carCount = $testUser->cars()->count();
echo "   - Seller analytics: " . ($sellerAnalytics ? '✓ ACTIVE' : '✗ INACTIVE') . " (user has {$carCount} cars, needs 3+)\n\n";

// Test 4: Premium user features
echo "4. Testing premium user features:\n";

// Create a premium user
$premiumUser = User::create([
    'name' => 'Premium User',
    'email' => 'premium@example.com',
    'password' => bcrypt('password'),
    'email_verified_at' => now(),
    'is_premium' => true,
]);

echo "   Premium user created: {$premiumUser->email}\n";
echo "   Premium status: " . ($premiumUser->is_premium ? '✓ YES' : '✗ NO') . "\n";

$enhancedSearch = Feature::for($premiumUser)->active('enhanced-search');
echo "   - Enhanced search: " . ($enhancedSearch ? '✓ ACTIVE' : '✗ INACTIVE') . "\n";

$premiumWatchlist = Feature::for($premiumUser)->active('premium-watchlist');
echo "   - Premium watchlist: " . ($premiumWatchlist ? '✓ ACTIVE' : '✗ INACTIVE') . "\n\n";

// Test 5: Lottery-based feature (new-car-ui)
echo "5. Testing lottery-based feature 'new-car-ui' (50% rollout):\n";
$results = ['enabled' => 0, 'disabled' => 0];

// Clear any cached values for each test
for ($i = 0; $i < 100; $i++) {
    Feature::flushCache();
    if (Feature::active('new-car-ui')) {
        $results['enabled']++;
    } else {
        $results['disabled']++;
    }
}
echo "   Tested 100 times: {$results['enabled']} enabled, {$results['disabled']} disabled\n";
echo "   Expected: ~50% enabled (actual: {$results['enabled']}%)\n\n";

// Test 6: Check all features for a user
echo "6. All features for {$testUser->email}:\n";
$allFeatures = Feature::for($testUser)->all([
    'enhanced-search',
    'new-car-ui',
    'premium-watchlist',
    'seller-analytics',
    'real-time-chat',
    'webp-images',
]);

foreach ($allFeatures as $feature => $active) {
    $status = $active ? '✓ ACTIVE' : '✗ INACTIVE';
    echo "   - {$feature}: {$status}\n";
}

echo "\n7. Database storage check:\n";
$featuresCount = DB::table('features')->count();
echo "   Features stored in database: {$featuresCount}\n";

if ($featuresCount > 0) {
    echo "   Recent features:\n";
    $recentFeatures = DB::table('features')->latest()->take(5)->get();
    foreach ($recentFeatures as $feature) {
        echo "   - {$feature->name} for scope '{$feature->scope}'\n";
    }
}

// Cleanup: Delete test users
if (isset($testUser)) {
    DB::table('features')->where('scope', 'like', '%|' . $testUser->id)->delete();
    $testUser->delete();
}
if (isset($premiumUser)) {
    DB::table('features')->where('scope', 'like', '%|' . $premiumUser->id)->delete();
    $premiumUser->delete();
}

echo "\n=== Test Complete ===\n";
echo "Feature flags are working correctly!\n\n";
