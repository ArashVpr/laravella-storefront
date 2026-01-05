<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maker extends Model
{
    /** @phpstan-ignore-next-line */
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * @return HasMany<Car, $this>
     */
    public function cars(): HasMany
    {
        return $this->hasMany(Car::class);
    }

    /**
     * @return HasMany<Models, $this>
     */
    public function models(): HasMany
    {
        return $this->hasMany(Models::class);
    }
}
