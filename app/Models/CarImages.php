<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImages extends Model
{
    protected $fillable = [
        'position',
        'image_path',
    ];
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
