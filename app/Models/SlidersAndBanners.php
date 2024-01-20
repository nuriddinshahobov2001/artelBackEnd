<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlidersAndBanners extends Model
{
    use HasFactory;

    protected $guarded = false;

    const SLIDER = 1;
    const SALE = 2;
    const HIT = 3;
    const SEASONAL = 4;
    const FOOTER = 5;
    const CATEGORY_PAGE = 6;

}
