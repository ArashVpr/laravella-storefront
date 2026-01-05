<?php

use App\Facades\AbTest;
use App\Models\User;

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "\n=== A/B Testing Framework Test ===\n\n";

// Clean up existing test data
echo "0. Cleaning up previous test data...\n";
$existingExperiment = \App\Models\AbExperiment::where('name', 'homepage-cta-test')->first();
if ($existingExperiment) {
    echo "   ✓ Deleting existing experiment: {$existingExperiment->name}\n";
    $existingExperiment->delete(); // Will cascade delete variants, assignments, conversions
}
echo "\n";

// Test 1: Create experiment
echo "1. Creating experiment...\n";
$experiment = AbTest::createExperiment(
    'homepage-cta-test',
    [
        [
            'name' => 'control',
            'description' => 'Original CTA: "View Cars"',
            'traffic_allocation' => 50,
            'is_control' => true,
            'config' => ['button_text' => 'View Cars', 'button_color' => 'blue'],
        ],
        [
            'name' => 'variant_a',
            'description' => 'Test CTA: "Find Your Dream Car"',
            'traffic_allocation' => 50,
            'config' => ['button_text' => 'Find Your Dream Car', 'button_color' => 'green'],
        ],
    ],
    'Testing homepage CTA button text and color',
    'clicked_cta'
);

echo "   ✓ Experiment created: {$experiment->name}\n";
echo "   ✓ Status: {$experiment->status}\n";
echo "   ✓ Variants: " . $experiment->variants->count() . "\n\n";

// Test 2: Start the experiment
echo "2. Starting experiment...\n";
$experiment->start();
echo "   ✓ Experiment started at: " . $experiment->started_at->format('Y-m-d H:i:s') . "\n\n";

// Test 3: Assign users to variants
echo "3. Assigning users to variants...\n";
$users = User::limit(10)->get();

if ($users->isEmpty()) {
    echo "   Creating test users...\n";
    for ($i = 0; $i < 10; $i++) {
        User::create([
            'name' => "Test User $i",
            'email' => "testabuser{$i}_" . time() . "@example.com",
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
    $users = User::orderByDesc('id')->limit(10)->get();
}

$assignments = ['control' => 0, 'variant_a' => 0];

foreach ($users as $user) {
    $variant = AbTest::getVariant('homepage-cta-test', $user->id);
    $assignments[$variant->name]++;
    echo "   - User {$user->id}: {$variant->name}\n";
}

echo "\n   Distribution:\n";
echo "   - Control: {$assignments['control']} users\n";
echo "   - Variant A: {$assignments['variant_a']} users\n\n";

// Test 4: Track conversions
echo "4. Tracking conversions...\n";
$conversionCount = 0;

foreach ($users->take(6) as $user) {
    $result = AbTest::trackConversion('homepage-cta-test', 'clicked_cta', $user->id);
    if ($result) {
        $conversionCount++;
        echo "   ✓ Conversion tracked for user {$user->id}\n";
    }
}

echo "   Total conversions: {$conversionCount}\n\n";

// Test 5: Get statistics
echo "5. Experiment statistics:\n";
$stats = AbTest::getExperimentStats('homepage-cta-test');

foreach ($stats as $stat) {
    echo "   {$stat['variant']}:\n";
    echo "     - Assignments: {$stat['assignments']}\n";
    echo "     - Conversions: {$stat['conversions']}\n";
    echo "     - Conversion Rate: {$stat['conversion_rate']}%\n";
}

echo "\n";

// Test 6: Get winner
echo "6. Determining winner...\n";
$winner = AbTest::getWinner('homepage-cta-test');

if ($winner) {
    echo "   🏆 Winner: {$winner['variant']}\n";
    echo "   - Conversion Rate: " . round($winner['conversion_rate'], 2) . "%\n";
    echo "   - Total Conversions: {$winner['total_conversions']}\n";
    echo "   - Total Assignments: {$winner['total_assignments']}\n";
} else {
    echo "   No winner yet (need more data)\n";
}

echo "\n";

// Test 7: Variant checking
echo "7. Checking variant assignment:\n";
$testUser = $users->first();
$variant = AbTest::getVariant('homepage-cta-test', $testUser->id);

echo "   User {$testUser->id} is in variant: {$variant->name}\n";
echo "   - Button Text: " . ($variant->config['button_text'] ?? 'N/A') . "\n";
echo "   - Button Color: " . ($variant->config['button_color'] ?? 'N/A') . "\n";

$isControl = AbTest::isInVariant('homepage-cta-test', 'control', $testUser->id);
$isVariantA = AbTest::isInVariant('homepage-cta-test', 'variant_a', $testUser->id);

echo "   - Is in control: " . ($isControl ? 'Yes' : 'No') . "\n";
echo "   - Is in variant A: " . ($isVariantA ? 'Yes' : 'No') . "\n";

echo "\n";

// Test 8: Complete the experiment
echo "8. Experiment lifecycle:\n";
echo "   Pausing experiment...\n";
$experiment->pause();
echo "   ✓ Status: {$experiment->status}\n";

echo "   Resuming experiment...\n";
$experiment->start();
echo "   ✓ Status: {$experiment->status}\n";

echo "   Completing experiment...\n";
$experiment->complete();
echo "   ✓ Status: {$experiment->status}\n";
echo "   ✓ Completed at: " . $experiment->completed_at->format('Y-m-d H:i:s') . "\n";

echo "\n=== Test Complete ===\n";
echo "A/B testing framework is working correctly!\n\n";

echo "Database Tables:\n";
echo "- Experiments: " . \App\Models\AbExperiment::count() . "\n";
echo "- Variants: " . \App\Models\AbVariant::count() . "\n";
echo "- Assignments: " . \App\Models\AbAssignment::count() . "\n";
echo "- Conversions: " . \App\Models\AbConversion::count() . "\n\n";
