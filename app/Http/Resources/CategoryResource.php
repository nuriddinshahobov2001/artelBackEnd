<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $childCategories = $this->child($this->category_id);

        return [
            'category_id' => $this->category_id,
            'name' => $this->getParentCategory($this->category_id)['name'],
            'slug' => $this->slug,
            'image' => $this->image,
            'child' => $childCategories
        ];
    }

    public function getParentCategory($ID)
    {
        return Category::where('category_id', $ID)->where('parent_id', '=', null)->select('name')->first();
    }


    public function child($parentID)
    {
        return Category::where('parent_id', $parentID)->select('name', 'slug')->get();
    }
}
