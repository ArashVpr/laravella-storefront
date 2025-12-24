<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Car extends Model
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory, SoftDeletes, Searchable;

    protected $guarded = [];

    protected $casts = [
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function features(): HasOne
    {
        return $this->hasOne(CarFeature::class, 'car_id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(CarImage::class)->oldestOfMany('position');
    }

    public function images(): HasMany
    {
        return $this->HasMany(CarImage::class)->orderBy('position');
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
        return $this->belongsTo(Models::class);
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

    public function carFeatures(): BelongsToMany
    {
        return $this->belongsToMany(CarFeature::class, 'car_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function formatDate()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function getTitle()
    {
        return $this->year.' - '.$this->maker->name.' '.$this->model->name;
    }

    /**
     * Check if the car is currently featured.
     */
    public function isFeatured(): bool
    {
        if (!$this->is_featured) {
            return false;
        }

        if ($this->featured_until && $this->featured_until->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Mark the car as featured.
     */
    public function markAsFeatured(int $days = 30): void
    {
        $this->update([
            'is_featured' => true,
            'featured_until' => now()->addDays($days),
        ]);
    }

    /**
     * Remove featured status.
     */
    public function removeFeatured(): void
    {
        $this->update([
            'is_featured' => false,
            'featured_until' => null,
        ]);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'year' => $this->year,
            'price' => $this->price,
            'mileage' => $this->mileage,
            'description' => $this->description,
            'maker' => $this->maker->name,
            'model' => $this->model->name,
            'fuel_type' => $this->fuelType->name,
            'car_type' => $this->carType->name,
            'city' => $this->city->name,
            'state' => $this->city->state->name,
            'location' => $this->city->name . ', ' . $this->city->state->name,
            'is_featured' => (bool) $this->is_featured,
            'created_at' => $this->created_at->timestamp,
        ];
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'cars_index';
    }
}
