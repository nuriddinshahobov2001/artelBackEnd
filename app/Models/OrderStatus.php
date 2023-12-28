<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    protected $guarded = false;

    const UNDER_CONSIDERATION = 1;
    const APPROVED = 2;
    const COMPLETED = 3;
    const REJECTED = 4;
}
