<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Car
 */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'make' => [
                'id' => $this->maker->id,
                'name' => $this->maker->name,
            ],
            'model' => [
                'id' => $this->model->id,
                'name' => $this->model->name,
            ],
            'year' => $this->year,
            'price' => [
                'amount' => $this->price,
                'currency' => 'USD',
                'formatted' => '$'.number_format($this->price, 0),
            ],
            'mileage' => $this->mileage,
            'fuel_type' => [
                'id' => $this->fuelType->id,
                'name' => $this->fuelType->name,
            ],
            'car_type' => $this->when($this->carType, [
                'id' => $this->carType?->id,
                'name' => $this->carType?->name,
            ]),
            'location' => [
                'city' => $this->city->name,
                'state' => $this->city->state->name ?? null,
            ],
            'description' => $this->description,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'features' => $this->when($this->relationLoaded('features'), function () {
                return new CarFeaturesResource($this->features);
            }),
            'owner' => [
                'name' => $this->owner->name,
                'phone' => $this->when(
                    $request->user()?->id === $this->user_id || $request->has('show_phone'),
                    $this->owner->phone
                ),
                'email' => $this->when(false, $this->owner->email), // Never expose email via API
            ],
            'is_favorite' => $this->when($request->user(), function () use ($request) {
                return $request->user()->favoriteCars()->where('car_id', $this->id)->exists();
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'links' => [
                'self' => route('api.v1.cars.show', $this->id),
                'web' => route('car.show', $this->id),
            ],
        ];
    }
}
