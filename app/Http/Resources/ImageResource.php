<?php

namespace App\Http\Resources;

use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CarImage
 */
class ImageResource extends JsonResource
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
            'url' => asset('storage/'.$this->image_path),
            'position' => $this->position,
            'is_primary' => $this->position === 1,
        ];
    }
}
