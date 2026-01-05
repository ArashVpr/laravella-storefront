<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CarImage extends Model
{
    /** @use HasFactory<\Database\Factories\CarImageFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'position',
        'image_path',
    ];

    /**
     * @return BelongsTo<Car, $this>
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getUrl(): string
    {
        // bring the image from database
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }

        // if the image is not in the database, get it from the storage
        return Storage::url($this->image_path);
    }
}
