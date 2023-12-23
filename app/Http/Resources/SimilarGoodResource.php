<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimilarGoodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $image = null;
        foreach ($this->images as $img){
            if ($img->is_main === 1) {
                $image = $img->image;
            }
        }

        return [
            'id' => $this->good_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sale' => $this->sale,
            'price' => $this->price,
            'image' => $image
        ];
    }
}
