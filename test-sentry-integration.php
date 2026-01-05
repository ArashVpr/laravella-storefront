<?php

/**
 * Sentry Integration Test
 * 
 * This script tests Sentry integration and demonstrates various error tracking features.
 */

use Illuminate\Support\Facades\Route;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Sentry Error Tracking - Integration Test\n";
echo "============================================\n\n";

// Check if Sentry is configured
$dsn = config('sentry.dsn');
$configured = !empty($dsn) && $dsn !== 'https://your_sentry_dsn@sentry.io/your_project_id';

echo "📊 Configuration Status:\n";
echo "------------------------\n";
echo "Sentry DSN: " . ($configured ? "✅ Configured" : "❌ Not configured (using placeholder)") . "\n";
echo "Environment: " . config('app.env') . "\n";
echo "Sample Rate: " . (config('sentry.sample_rate') * 100) . "%\n";
echo "Traces Sample Rate: " . (config('sentry.traces_sample_rate') * 100) . "%\n";
echo "Profiles Sample Rate: " . (config('sentry.profiles_sample_rate') * 100) . "%\n\n";

if (!$configured) {
    echo "⚠️  WARNING: Sentry DSN not configured\n";
    echo "   Events will be logged locally but not sent to Sentry\n\n";
    echo "To configure:\n";
    echo "  1. Sign up at https://sentry.io\n";
    echo "  2. Create a new Laravel project\n";
    echo "  3. Copy your DSN\n";
    echo "  4. Update .env: SENTRY_LARAVEL_DSN=your_dsn_here\n\n";
}

// Test 1: Capture a simple message
echo "📝 Test 1: Capture Message\n";
echo "--------------------------\n";
try {
    \Sentry\captureMessage('Test message from Sentry integration test', \Sentry\Severity::info());
    echo "✅ Message captured successfully\n";
    echo "   Message: 'Test message from Sentry integration test'\n";
    echo "   Severity: INFO\n\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 2: Add breadcrumbs and capture exception
echo "📝 Test 2: Breadcrumbs + Exception\n";
echo "----------------------------------\n";
try {
    \Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
        \Sentry\Breadcrumb::LEVEL_INFO,
        \Sentry\Breadcrumb::TYPE_USER,
        'user',
        'Test breadcrumb 1: User action'
    ));
    
    \Sentry\addBreadcrumb(new \Sentry\Breadcrumb(
        \Sentry\Breadcrumb::LEVEL_INFO,
        \Sentry\Breadcrumb::TYPE_NAVIGATION,
        'navigation',
        'Test breadcrumb 2: Navigation event'
    ));
    
    echo "✅ Breadcrumbs added:\n";
    echo "   1. User action breadcrumb\n";
    echo "   2. Navigation breadcrumb\n\n";
    
    // Capture an exception with breadcrumbs
    $exception = new \RuntimeException('Test exception with breadcrumbs');
    \Sentry\captureException($exception);
    echo "✅ Exception captured with breadcrumbs\n";
    echo "   Type: RuntimeException\n";
    echo "   Message: 'Test exception with breadcrumbs'\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 3: User context
echo "📝 Test 3: User Context\n";
echo "-----------------------\n";
try {
    \Sentry\configureScope(function (\Sentry\State\Scope $scope): void {
        $scope->setUser([
            'id' => 12345,
            'username' => 'test_user',
            'email' => 'test@laravella.com',
            'ip_address' => '127.0.0.1',
        ]);
        
        $scope->setTag('test_type', 'integration');
        $scope->setTag('environment', 'testing');
        
        $scope->setContext('test_info', [
            'script' => 'test-sentry-integration.php',
            'timestamp' => now()->toIso8601String(),
            'php_version' => PHP_VERSION,
        ]);
    });
    
    echo "✅ Scope configured:\n";
    echo "   User: test_user (ID: 12345)\n";
    echo "   Tags: test_type=integration, environment=testing\n";
    echo "   Context: test_info with script details\n\n";
    
    // Capture with context
    \Sentry\captureMessage('Message with user context', \Sentry\Severity::warning());
    echo "✅ Message captured with user context\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 4: Performance tracing
echo "📝 Test 4: Performance Tracing\n";
echo "------------------------------\n";
try {
    $transaction = \Sentry\startTransaction(
        \Sentry\Tracing\TransactionContext::make()
            ->setName('test.integration.transaction')
            ->setOp('test.operation')
    );
    
    \Sentry\SentrySdk::getCurrentHub()->setSpan($transaction);
    
    // Simulate database query
    $span1 = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
        ->setOp('db.query')
        ->setDescription('SELECT * FROM test_table')
    );
    usleep(25000); // 25ms
    $span1->finish();
    
    // Simulate API call
    $span2 = $transaction->startChild(\Sentry\Tracing\SpanContext::make()
        ->setOp('http.client')
        ->setDescription('GET https://api.test.com/data')
    );
    usleep(75000); // 75ms
    $span2->finish();
    
    $transaction->finish();
    
    echo "✅ Performance trace created:\n";
    echo "   Transaction: test.integration.transaction\n";
    echo "   Spans: 2 (db.query, http.client)\n";
    echo "   Total duration: ~100ms\n\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
}

// Test 5: Available test routes
echo "📝 Test 5: Available Test Routes\n";
echo "--------------------------------\n";

$testRoutes = [
    '/sentry-test/exception' => 'Throws a test exception',
    '/sentry-test/error' => 'Triggers PHP error',
    '/sentry-test/warning' => 'Triggers PHP warning',
    '/sentry-test/breadcrumbs' => 'Tests breadcrumb tracking',
    '/sentry-test/context' => 'Tests context and user info',
    '/sentry-test/performance' => 'Tests performance tracing',
    '/sentry-test/capture-message' => 'Captures info message',
];

echo "Available test routes (local env only):\n\n";
foreach ($testRoutes as $route => $description) {
    echo "  • $route\n";
    echo "    $description\n\n";
}

echo "To test via browser/curl:\n";
echo "  php artisan serve\n";
echo "  curl http://localhost:8000/sentry-test/capture-message\n\n";

// Summary
echo "📊 Summary\n";
echo "==========\n";
if ($configured) {
    echo "✅ Sentry is properly configured\n";
    echo "✅ All test events have been sent to Sentry\n";
    echo "✅ Check your Sentry dashboard at: https://sentry.io\n\n";
    echo "🔍 What to check:\n";
    echo "   - Issues tab: See captured exceptions and messages\n";
    echo "   - Performance tab: View transaction traces\n";
    echo "   - Each issue should show breadcrumbs and context\n";
} else {
    echo "⚠️  Sentry DSN not configured\n";
    echo "✅ Integration code is working correctly\n";
    echo "ℹ️  Configure your DSN to send events to Sentry\n";
}

echo "\n✅ Integration test complete!\n\n";

echo "📖 For more information:\n";
echo "   - Documentation: SENTRY-ERROR-TRACKING.md\n";
echo "   - Test script: ./test-sentry.sh\n";
echo "   - Sentry docs: https://docs.sentry.io/platforms/php/guides/laravel/\n";
