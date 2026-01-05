<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AbAssignment extends Model
{
    protected $fillable = [
        'experiment_id',
        'variant_id',
        'user_id',
        'session_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function experiment(): BelongsTo
    {
        return $this->belongsTo(AbExperiment::class, 'experiment_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(AbVariant::class, 'variant_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversions(): HasMany
    {
        return $this->hasMany(AbConversion::class, 'assignment_id');
    }
}
