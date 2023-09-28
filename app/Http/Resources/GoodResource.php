<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'full_description' => $this->full_description,
            'category_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'price' => $this->price,
            'sale' => $this->sale,
            'count' => $this->count
        ];
    }
}
