<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * @return HasOne<CarFeature, $this>
     */
    public function features(): HasOne
    {
        return $this->hasOne(CarFeature::class, 'car_id');
    }

    /**
     * @return HasOne<CarImage, $this>
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(CarImage::class)->oldestOfMany('position');
    }

    /**
     * @return HasMany<CarImage, $this>
     */
    public function images(): HasMany
    {
        return $this->HasMany(CarImage::class)->orderBy('position');
    }

    /**
     * @return BelongsToMany<User, $this>
     */
    public function favoredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorite_cars');
    }

    /**
     * @return BelongsTo<CarType, $this>
     */
    public function carType(): BelongsTo
    {
        return $this->belongsTo(CarType::class);
    }

    /**
     * @return BelongsTo<FuelType, $this>
     */
    public function fuelType(): BelongsTo
    {
        return $this->belongsTo(FuelType::class);
    }

    /**
     * @return BelongsTo<Maker, $this>
     */
    public function maker(): BelongsTo
    {
        return $this->belongsTo(Maker::class);
    }

    /**
     * @return BelongsTo<Models, $this>
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(Models::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return HasMany<CarImage, $this>
     */
    public function carImages(): HasMany
    {
        return $this->hasMany(CarImage::class);
    }

    /**
     * @return BelongsToMany<CarFeature, $this>
     */
    public function carFeatures(): BelongsToMany
    {
        return $this->belongsToMany(CarFeature::class, 'car_id');
    }

    public function formatDate(): string
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getTitle(): string
    {
        return $this->year.' - '.$this->maker->name.' '.$this->model->name;
    }
}
