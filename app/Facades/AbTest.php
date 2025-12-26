<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \App\Models\AbVariant|null getVariant(string $experimentName, ?int $userId = null, ?string $sessionId = null)
 * @method static bool trackConversion(string $experimentName, string $goal, ?int $userId = null, ?string $sessionId = null, ?float $value = null, ?array $metadata = null)
 * @method static bool isInVariant(string $experimentName, string $variantName, ?int $userId = null, ?string $sessionId = null)
 * @method static array|null getExperimentStats(string $experimentName)
 * @method static \App\Models\AbExperiment createExperiment(string $name, array $variants, ?string $description = null, ?string $goal = null)
 * @method static array|null getWinner(string $experimentName)
 *
 * @see \App\Services\AbTestingService
 */
class AbTest extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'abtest';
    }
}
