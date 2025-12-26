<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbVariant extends Model
{
    protected $fillable = [
        'experiment_id',
        'name',
        'description',
        'traffic_allocation',
        'is_control',
        'config',
    ];

    protected $casts = [
        'is_control' => 'boolean',
        'traffic_allocation' => 'integer',
        'config' => 'array',
    ];

    public function experiment(): BelongsTo
    {
        return $this->belongsTo(AbExperiment::class, 'experiment_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AbAssignment::class, 'variant_id');
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(AbConversion::class, 'variant_id');
    }

    public function getConversionRate(): float
    {
        $totalAssignments = $this->assignments()->count();
        
        if ($totalAssignments === 0) {
            return 0.0;
        }

        $totalConversions = $this->conversions()->count();
        
        return ($totalConversions / $totalAssignments) * 100;
    }
}
