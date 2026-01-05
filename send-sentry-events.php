<?php

/**
 * Advanced Sentry Test - Send Various Event Types
 */

use App\Models\User;
use App\Models\Car;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🚀 Sending Advanced Sentry Test Events\n";
echo "======================================\n\n";

// Test 1: Different severity levels
echo "📝 Test 1: Different Severity Levels\n";
echo "------------------------------------\n";

\Sentry\captureMessage('Info: User browsing car listings', \Sentry\Severity::info());
echo "✓ INFO message sent\n";

\Sentry\captureMessage('Warning: Low disk space detected', \Sentry\Severity::warning());
echo "✓ WARNING message sent\n";

\Sentry\captureMessage('Error: Failed to connect to payment gateway', \Sentry\Severity::error());
echo "✓ ERROR message sent\n";

\Sentry\captureMessage('Fatal: Database connection lost', \Sentry\Severity::fatal());
echo "✓ FATAL message sent\n\n";

// Test 2: Exception with real-world context
echo "📝 Test 2: Car Purchase Exception\n";
echo "---------------------------------\n";

try {
    $car = Car::first();
    
    \Sentry\configureScope(function ($scope) use ($car) {
        $scope->setUser([
            'id' => 999,
            'email' => 'test@example.com',
            'username' => 'Test User',
        ]);
        
        $scope->setTag('feature', 'car-purchase');
        $scope->setTag('car_id', $car->id ?? 'N/A');
        
        $scope->setContext('car_details', [
            'id' => $car->id ?? null,
            'title' => $car->getTitle() ?? 'N/A',
            'price' => $car->price ?? 0,
            'featured' => $car->featured ?? false,
        ]);
        
        $scope->setContext('purchase_attempt', [
            'amount' => 29.99,
            'currency' => 'USD',
            'payment_method' => 'stripe',
        ]);
    });
    
    throw new \RuntimeException('Simulated payment processing error: Card declined');
    
} catch (\Exception $e) {
    \Sentry\captureException($e);
    echo "✓ Payment exception captured with car context\n\n";
}

// Test 3: Breadcrumbs showing user journey
echo "📝 Test 3: User Journey with Breadcrumbs\n";
echo "----------------------------------------\n";

\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_NAVIGATION,
    'navigation',
    'User visited homepage'
));

\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_USER,
    'search',
    'Searched for: BMW X5 2020'
));

\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_USER,
    'click',
    'Clicked on car listing #123'
));

\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_INFO,
    \Sentry\Breadcrumb::TYPE_USER,
    'action',
    'Added to watchlist'
));

\Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
    \Sentry\Breadcrumb::LEVEL_WARNING,
    \Sentry\Breadcrumb::TYPE_ERROR,
    'error',
    'Failed to load car images'
));

try {
    throw new \Exception('Error displaying car details after adding to watchlist');
} catch (\Exception $e) {
    \Sentry\captureException($e);
    echo "✓ Exception with full user journey breadcrumbs\n\n";
}

// Test 4: Performance transaction with multiple spans
echo "📝 Test 4: Complex Performance Transaction\n";
echo "------------------------------------------\n";

$transaction = \Sentry\startTransaction(
    \Sentry\Tracing\TransactionContext::make()
        ->setName('car.search.advanced')
        ->setOp('http.server')
);

\Sentry\SentrySdk::getCurrentHub()->setSpan($transaction);

// Database query span
$dbSpan = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
    ->setOp('db.query')
    ->setDescription('SELECT * FROM cars WHERE price < 50000')
);
usleep(30000); // 30ms
$dbSpan->finish();

// External API span
$apiSpan = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
    ->setOp('http.client')
    ->setDescription('GET https://api.carfax.com/vehicle-history')
);
usleep(120000); // 120ms
$apiSpan->finish();

// Image processing span
$imgSpan = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
    ->setOp('image.processing')
    ->setDescription('Optimize and resize car images')
);
usleep(80000); // 80ms
$imgSpan->finish();

// Cache check span
$cacheSpan = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
    ->setOp('cache.get')
    ->setDescription('Redis: get car_search_results_hash')
);
usleep(5000); // 5ms
$cacheSpan->finish();

$transaction->finish();

echo "✓ Performance transaction with 4 spans:\n";
echo "  - Database query (30ms)\n";
echo "  - External API call (120ms)\n";
echo "  - Image processing (80ms)\n";
echo "  - Cache lookup (5ms)\n\n";

// Test 5: Different exception types
echo "📝 Test 5: Various Exception Types\n";
echo "-----------------------------------\n";

$exceptions = [
    new \InvalidArgumentException('Invalid car ID provided'),
    new \RuntimeException('Failed to process car listing'),
    new \LogicException('Cannot feature already featured car'),
    new \PDOException('Database connection timeout'),
];

foreach ($exceptions as $exception) {
    \Sentry\captureException($exception);
    echo "✓ " . get_class($exception) . "\n";
}

echo "\n";

// Summary
echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║              SENTRY TEST EVENTS SENT SUCCESSFULLY            ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

echo "📊 Events Sent:\n";
echo "  • 4 Messages (info, warning, error, fatal)\n";
echo "  • 6 Exceptions (with various contexts)\n";
echo "  • 5 Breadcrumb trails\n";
echo "  • 1 Performance transaction (4 spans)\n";
echo "  • User context, tags, and custom data\n\n";

echo "🔍 Check Your Sentry Dashboard:\n";
echo "  → https://sentry.io/organizations/YOUR_ORG/issues/\n\n";

echo "What to look for:\n";
echo "  1. Issues Tab:\n";
echo "     - 10+ new issues grouped by type\n";
echo "     - Stack traces with file/line numbers\n";
echo "     - Breadcrumbs showing user actions\n";
echo "     - User info (ID: 999, test@example.com)\n";
echo "     - Tags: feature, car_id, environment\n\n";

echo "  2. Performance Tab:\n";
echo "     - Transaction: car.search.advanced\n";
echo "     - 4 child spans (db, http, image, cache)\n";
echo "     - Total duration ~235ms\n\n";

echo "  3. Each Issue Should Show:\n";
echo "     - Environment: local\n";
echo "     - Release: Not set (configure SENTRY_RELEASE)\n";
echo "     - Context data (car details, purchase info)\n";
echo "     - Breadcrumbs timeline\n\n";

echo "✅ Test Complete! Events should appear in ~10 seconds.\n";
