<?php

namespace App\Http\Resources;

use App\Models\Image;
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
        $image = null;
        foreach ($this->images as $img) {
            if ($img->is_main === 1) {
                $image = $img->image;
            }
        }

        return [
            'id' => $this->good_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'full_description' => json_decode($this->full_description),
            'price' => $this->price,
            'sale' => $this->sale,
            'count' => $this->count,
            'brand' => $this->brand?->name,
            'brand_slug' => $this->brand?->slug,
            'category' => $this->category?->name,
            'category_slug' => $this->category?->slug,
            'image' => $image,
            'images' => $this->all_images(),
        ];
    }
    
    public function all_images()
    {
        $images = array();
        foreach ($this->images as $img) {
            if($img->is_main != 1) {
                $images[] = $img->image;
            }
        }
        return $images;
    }
}
