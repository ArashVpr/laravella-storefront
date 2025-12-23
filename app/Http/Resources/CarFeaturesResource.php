<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarFeaturesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'gps' => (bool) $this->gps,
            'camera' => (bool) $this->camera,
            'bluetooth' => (bool) $this->bluetooth,
            'air_conditioner' => (bool) $this->air_conditioner,
            'abs' => (bool) $this->abs,
            'leather_seats' => (bool) $this->leather_seats,
            'sunroof' => (bool) $this->sunroof,
        ];
    }
}
