<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory, SoftDeletes;

    public function features(): HasOne
    {
        return $this->hasOne(CarFeatures::class);
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(CarImage::class)->oldestOfMany('position');
    }

    public function images(): HasMany
    {
        return $this->HasMany(CarImage::class);
    }

    public function favoredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_cars');
    }

    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }


    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(model::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function carImages(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }
    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }
    public function carFeatures(): BelongsToMany
    {
        return $this->belongsToMany(CarFeature::class, 'car_feature_car');
    }


}
