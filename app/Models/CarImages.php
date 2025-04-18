<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Factories\HasFactory;



class CarImages extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'image_path',
    ];
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
