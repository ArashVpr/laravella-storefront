<?php

use App\Models\AbAssignment;
use App\Models\AbConversion;
use App\Models\AbExperiment;
use App\Models\AbVariant;
use App\Models\User;
use App\Services\AbTestingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->service = new AbTestingService();
});

test('can create experiment with variants', function () {
    $experiment = $this->service->createExperiment(
        'button-color-test',
        [
            [
                'name' => 'control',
                'description' => 'Blue button',
                'traffic_allocation' => 50,
                'is_control' => true,
            ],
            [
                'name' => 'variant_a',
                'description' => 'Red button',
                'traffic_allocation' => 50,
            ],
        ],
        'Testing button colors for signup',
        'signup_completed'
    );

    expect($experiment)->toBeInstanceOf(AbExperiment::class)
        ->and($experiment->name)->toBe('button-color-test')
        ->and($experiment->status)->toBe('draft')
        ->and($experiment->variants)->toHaveCount(2);
});

test('get variant assigns user to experiment', function () {
    $user = User::factory()->create();
    $experiment = createTestExperiment();
    $experiment->start();

    $variant = $this->service->getVariant('test-experiment', $user->id);

    expect($variant)->toBeInstanceOf(AbVariant::class);
    
    $this->assertDatabaseHas('ab_assignments', [
        'experiment_id' => $experiment->id,
        'user_id' => $user->id,
        'variant_id' => $variant->id,
    ]);
});

test('get variant returns same variant for same user', function () {
    $user = User::factory()->create();
    $experiment = createTestExperiment();
    $experiment->start();

    $variant1 = $this->service->getVariant('test-experiment', $user->id);
    $variant2 = $this->service->getVariant('test-experiment', $user->id);

    expect($variant1->id)->toBe($variant2->id);
    expect(AbAssignment::where('user_id', $user->id)->count())->toBe(1);
});

test('get variant returns null for non running experiment', function () {
    $user = User::factory()->create();
    createTestExperiment(); // Status is 'draft'

    $variant = $this->service->getVariant('test-experiment', $user->id);

    expect($variant)->toBeNull();
});

test('track conversion creates conversion record', function () {
    $user = User::factory()->create();
    $experiment = createTestExperiment();
    $experiment->start();

    $variant = $this->service->getVariant('test-experiment', $user->id);

    $result = $this->service->trackConversion(
        'test-experiment',
        'signup_completed',
        $user->id,
        null,
        99.99,
        ['source' => 'google']
    );

    expect($result)->toBeTrue();
    
    $this->assertDatabaseHas('ab_conversions', [
        'experiment_id' => $experiment->id,
        'variant_id' => $variant->id,
        'goal' => 'signup_completed',
        'value' => 99.99,
    ]);
});

test('track conversion prevents duplicate conversions', function () {
    $user = User::factory()->create();
    $experiment = createTestExperiment();
    $experiment->start();

    $this->service->getVariant('test-experiment', $user->id);

    $result1 = $this->service->trackConversion('test-experiment', 'signup_completed', $user->id);
    $result2 = $this->service->trackConversion('test-experiment', 'signup_completed', $user->id);

    expect($result1)->toBeTrue()
        ->and($result2)->toBeFalse()
        ->and(AbConversion::where('goal', 'signup_completed')->count())->toBe(1);
});

test('is in variant returns correct boolean', function () {
    $user = User::factory()->create();
    $experiment = createTestExperiment();
    $experiment->start();

    $variant = $this->service->getVariant('test-experiment', $user->id);

    expect($this->service->isInVariant('test-experiment', $variant->name, $user->id))->toBeTrue()
        ->and($this->service->isInVariant('test-experiment', 'non-existent-variant', $user->id))->toBeFalse();
});

test('get experiment stats calculates correctly', function () {
    $experiment = createTestExperiment();
    $experiment->start();

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $this->service->getVariant('test-experiment', $user1->id);
    $this->service->getVariant('test-experiment', $user2->id);
    $this->service->getVariant('test-experiment', $user3->id);

    $this->service->trackConversion('test-experiment', 'clicked', $user1->id);
    $this->service->trackConversion('test-experiment', 'clicked', $user2->id);

    $stats = $this->service->getExperimentStats('test-experiment');

    expect($stats)->toBeArray()->not->toBeEmpty();
    
    $totalAssignments = array_sum(array_column($stats, 'assignments'));
    expect($totalAssignments)->toBe(3);
});

test('get winner returns variant with most conversions', function () {
    $experiment = createTestExperiment();
    $experiment->start();

    $controlVariant = $experiment->variants()->where('name', 'control')->first();
    $testVariant = $experiment->variants()->where('name', 'variant_a')->first();

    // Control: 1 assignment, 0 conversions
    $user1 = User::factory()->create();
    AbAssignment::create([
        'experiment_id' => $experiment->id,
        'variant_id' => $controlVariant->id,
        'user_id' => $user1->id,
        'assigned_at' => now(),
    ]);

    // Variant A: 2 assignments, 2 conversions
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
    
    $assignment2 = AbAssignment::create([
        'experiment_id' => $experiment->id,
        'variant_id' => $testVariant->id,
        'user_id' => $user2->id,
        'assigned_at' => now(),
    ]);
    
    $assignment3 = AbAssignment::create([
        'experiment_id' => $experiment->id,
        'variant_id' => $testVariant->id,
        'user_id' => $user3->id,
        'assigned_at' => now(),
    ]);

    AbConversion::create([
        'experiment_id' => $experiment->id,
        'variant_id' => $testVariant->id,
        'assignment_id' => $assignment2->id,
        'goal' => 'conversion',
        'converted_at' => now(),
    ]);
    
    AbConversion::create([
        'experiment_id' => $experiment->id,
        'variant_id' => $testVariant->id,
        'assignment_id' => $assignment3->id,
        'goal' => 'conversion',
        'converted_at' => now(),
    ]);

    $winner = $this->service->getWinner('test-experiment');

    expect($winner)->toBeArray()
        ->and($winner['variant'])->toBe('variant_a')
        ->and($winner['total_conversions'])->toBe(2);
});

test('traffic allocation distributes users', function () {
    $experiment = AbExperiment::create([
        'name' => 'traffic-test',
        'status' => 'running',
    ]);

    AbVariant::create([
        'experiment_id' => $experiment->id,
        'name' => 'control',
        'traffic_allocation' => 80,
        'is_control' => true,
    ]);

    AbVariant::create([
        'experiment_id' => $experiment->id,
        'name' => 'variant',
        'traffic_allocation' => 20,
    ]);

    $controlCount = 0;
    $variantCount = 0;

    for ($i = 0; $i < 100; $i++) {
        $user = User::factory()->create();
        $variant = $this->service->getVariant('traffic-test', $user->id);
        
        if ($variant->name === 'control') {
            $controlCount++;
        } else {
            $variantCount++;
        }
    }

    // Control should get ~80%, variant ~20% (with some variance)
    expect($controlCount)->toBeGreaterThan(60)->toBeLessThan(95)
        ->and($variantCount)->toBeGreaterThan(5)->toBeLessThan(40);
});

// Helper function
function createTestExperiment(): AbExperiment
{
    $experiment = AbExperiment::create([
        'name' => 'test-experiment',
        'description' => 'Test experiment',
        'goal' => 'conversion',
        'status' => 'draft',
    ]);

    AbVariant::create([
        'experiment_id' => $experiment->id,
        'name' => 'control',
        'traffic_allocation' => 50,
        'is_control' => true,
    ]);

    AbVariant::create([
        'experiment_id' => $experiment->id,
        'name' => 'variant_a',
        'traffic_allocation' => 50,
    ]);

    return $experiment;
}
