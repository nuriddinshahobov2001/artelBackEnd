<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;
    protected $casts = [
        'full_description' => 'json'
    ];

    protected $guarded = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','category_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'good_id', 'good_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeFilter($query)
    {
        return $query->where([
            ['price', '!=', 0],
            ['name', '!=', ''],
            ['description', '!=', ''],
            ['full_description', '!=', '[]']
        ])->whereHas('images', function ($query) {
            $query->where('is_main', true);
        })->orderBy('created_at', 'desc');
    }

    public function scopeUnFilter($query)
    {
        return $query->where(function ($query) {
            $query->where('price', 0)
                ->orWhere('name', '')
                ->orWhere('description', '')
                ->orWhere('full_description', '[]');
        })->orWhere(function ($query) {
            $query->doesntHave('images')
                ->orWhereDoesntHave('images', function ($query) {
                    $query->where('is_main', true);
                });
        });
    }
}
