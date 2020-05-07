<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = [
        'brand_name',
        'origin_name',
        'amount',
        'remark'
    ];
}
