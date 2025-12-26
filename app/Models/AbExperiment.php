<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbExperiment extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'goal',
        'started_at',
        'completed_at',
        'metadata',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function variants(): HasMany
    {
        return $this->hasMany(AbVariant::class, 'experiment_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AbAssignment::class, 'experiment_id');
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(AbConversion::class, 'experiment_id');
    }

    public function isRunning(): bool
    {
        return $this->status === 'running';
    }

    public function start(): void
    {
        $this->update([
            'status' => 'running',
            'started_at' => now(),
        ]);
    }

    public function pause(): void
    {
        $this->update(['status' => 'paused']);
    }

    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function getWinner(): ?AbVariant
    {
        return $this->variants()
            ->withCount('conversions')
            ->orderByDesc('conversions_count')
            ->first();
    }

    public function getStats(): array
    {
        $variants = $this->variants()->withCount(['assignments', 'conversions'])->get();
        
        return $variants->map(function ($variant) {
            $conversionRate = $variant->assignments_count > 0
                ? ($variant->conversions_count / $variant->assignments_count) * 100
                : 0;

            return [
                'variant' => $variant->name,
                'assignments' => $variant->assignments_count,
                'conversions' => $variant->conversions_count,
                'conversion_rate' => round($conversionRate, 2),
            ];
        })->toArray();
    }
}
