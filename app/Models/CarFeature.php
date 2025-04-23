<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarFeature extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
