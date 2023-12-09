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
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'full_description' => json_decode($this->full_description),
            'price' => $this->price,
            'sale' => $this->sale,
            'count' => $this->count,
            'image' => $image,
//            'images' => $this->all_images($this->good_id),
            'images' => $this->all_images($this->id),
        ];
    }
    public function all_images($id)
    {
        $images = array();
        $good_imgs = Image::where([
            ['id', $id],
            ['is_main', '!==', 1]
        ])->get();

        foreach ($good_imgs as $img) {
            $images[] = $img->image;
        }
        return $images;
    }
}
