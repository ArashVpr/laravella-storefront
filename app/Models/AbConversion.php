<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbConversion extends Model
{
    protected $fillable = [
        'experiment_id',
        'variant_id',
        'assignment_id',
        'goal',
        'value',
        'metadata',
        'converted_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'metadata' => 'array',
        'converted_at' => 'datetime',
    ];

    public function experiment(): BelongsTo
    {
        return $this->belongsTo(AbExperiment::class, 'experiment_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(AbVariant::class, 'variant_id');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(AbAssignment::class, 'assignment_id');
    }
}
