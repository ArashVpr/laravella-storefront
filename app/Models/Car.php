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
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Car extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\CarFactory> */
    use HasFactory, SoftDeletes, Searchable, InteractsWithMedia;

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
        $maker = $this->maker?->name ?? 'Unknown';
        $model = $this->model?->name ?? 'Unknown';
        return $this->year.' - '.$maker.' '.$model;
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
            'id' => (int) $this->id,
            'year' => (int) $this->year,
            'price' => (float) $this->price,
            'mileage' => (int) $this->mileage,
            'description' => $this->description ?? '',
            'maker_id' => $this->maker_id,
            'model_id' => $this->model_id,
            'car_type_id' => $this->car_type_id,
            'fuel_type_id' => $this->fuel_type_id,
            'city_id' => $this->city_id,
            'is_featured' => (bool) $this->is_featured,
            'created_at' => $this->created_at ? $this->created_at->timestamp : null,
        ];
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'cars_index';
    }

    /**
     * Register media collections for the car.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg']);
    }

    /**
     * Register media conversions for car images.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail - 300x200
        $this->addMediaConversion('thumbnail')
            ->width(300)
            ->height(200)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images');

        // Medium - 800x600
        $this->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images');

        // Large - 1200x900
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(900)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images');

        // WebP conversions for better performance
        $this->addMediaConversion('thumbnail-webp')
            ->width(300)
            ->height(200)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');

        $this->addMediaConversion('medium-webp')
            ->width(800)
            ->height(600)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');

        $this->addMediaConversion('large-webp')
            ->width(1200)
            ->height(900)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');
    }
}
