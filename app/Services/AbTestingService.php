<?php

namespace App\Services;

use App\Models\AbAssignment;
use App\Models\AbConversion;
use App\Models\AbExperiment;
use App\Models\AbVariant;
use Illuminate\Support\Facades\Session;

class AbTestingService
{
    /**
     * Get or assign a variant for the given experiment and identifier
     */
    public function getVariant(string $experimentName, ?int $userId = null, ?string $sessionId = null): ?AbVariant
    {
        $experiment = AbExperiment::where('name', $experimentName)
            ->where('status', 'running')
            ->first();

        if (!$experiment) {
            return null;
        }

        // Use session ID if user ID not provided
        if (!$userId && !$sessionId) {
            $sessionId = Session::getId();
        }

        // Check if already assigned
        $assignment = AbAssignment::where('experiment_id', $experiment->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($assignment) {
            return $assignment->variant;
        }

        // Assign new variant based on traffic allocation
        $variant = $this->selectVariant($experiment);

        if (!$variant) {
            return null;
        }

        AbAssignment::create([
            'experiment_id' => $experiment->id,
            'variant_id' => $variant->id,
            'user_id' => $userId,
            'session_id' => $sessionId,
            'assigned_at' => now(),
        ]);

        return $variant;
    }

    /**
     * Select a variant based on traffic allocation
     */
    protected function selectVariant(AbExperiment $experiment): ?AbVariant
    {
        $variants = $experiment->variants;

        if ($variants->isEmpty()) {
            return null;
        }

        // Calculate total allocation
        $totalAllocation = $variants->sum('traffic_allocation');

        if ($totalAllocation === 0) {
            // Equal distribution if no allocation specified
            return $variants->random();
        }

        // Weighted random selection
        $random = rand(1, $totalAllocation);
        $sum = 0;

        foreach ($variants as $variant) {
            $sum += $variant->traffic_allocation;
            if ($random <= $sum) {
                return $variant;
            }
        }

        return $variants->first();
    }

    /**
     * Track a conversion for the experiment
     */
    public function trackConversion(
        string $experimentName,
        string $goal,
        ?int $userId = null,
        ?string $sessionId = null,
        ?float $value = null,
        ?array $metadata = null
    ): bool {
        $experiment = AbExperiment::where('name', $experimentName)
            ->where('status', 'running')
            ->first();

        if (!$experiment) {
            return false;
        }

        // Use session ID if user ID not provided
        if (!$userId && !$sessionId) {
            $sessionId = Session::getId();
        }

        // Find the assignment
        $assignment = AbAssignment::where('experiment_id', $experiment->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if (!$assignment) {
            return false;
        }

        // Check if already converted for this goal
        $existingConversion = AbConversion::where('assignment_id', $assignment->id)
            ->where('goal', $goal)
            ->exists();

        if ($existingConversion) {
            return false; // Don't track duplicate conversions
        }

        AbConversion::create([
            'experiment_id' => $experiment->id,
            'variant_id' => $assignment->variant_id,
            'assignment_id' => $assignment->id,
            'goal' => $goal,
            'value' => $value,
            'metadata' => $metadata,
            'converted_at' => now(),
        ]);

        return true;
    }

    /**
     * Check if user is in a specific variant
     */
    public function isInVariant(string $experimentName, string $variantName, ?int $userId = null, ?string $sessionId = null): bool
    {
        $variant = $this->getVariant($experimentName, $userId, $sessionId);
        
        return $variant && $variant->name === $variantName;
    }

    /**
     * Get experiment statistics
     */
    public function getExperimentStats(string $experimentName): ?array
    {
        $experiment = AbExperiment::where('name', $experimentName)->first();
        
        if (!$experiment) {
            return null;
        }

        return $experiment->getStats();
    }

    /**
     * Create a new experiment with variants
     */
    public function createExperiment(
        string $name,
        array $variants,
        ?string $description = null,
        ?string $goal = null
    ): AbExperiment {
        $experiment = AbExperiment::create([
            'name' => $name,
            'description' => $description,
            'goal' => $goal,
            'status' => 'draft',
        ]);

        $totalAllocation = 0;
        foreach ($variants as $variantData) {
            $allocation = $variantData['traffic_allocation'] ?? 0;
            $totalAllocation += $allocation;

            AbVariant::create([
                'experiment_id' => $experiment->id,
                'name' => $variantData['name'],
                'description' => $variantData['description'] ?? null,
                'traffic_allocation' => $allocation,
                'is_control' => $variantData['is_control'] ?? false,
                'config' => $variantData['config'] ?? null,
            ]);
        }

        return $experiment->fresh();
    }

    /**
     * Get the winner of an experiment (variant with highest conversion rate)
     */
    public function getWinner(string $experimentName): ?array
    {
        $experiment = AbExperiment::where('name', $experimentName)->first();
        
        if (!$experiment) {
            return null;
        }

        $winner = $experiment->getWinner();
        
        if (!$winner) {
            return null;
        }

        return [
            'variant' => $winner->name,
            'conversion_rate' => $winner->getConversionRate(),
            'total_conversions' => $winner->conversions()->count(),
            'total_assignments' => $winner->assignments()->count(),
        ];
    }
}
