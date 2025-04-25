<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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

    public function getUrl()
    {
        if (str_starts_with($this->image_path, 'http')) {
            return $this->image_path;
        }
        return Storage::url($this->image_path);
    }
}
