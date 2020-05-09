<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamMedicine extends Model
{
    protected $fillable = [
        'exam_id',
        'medicine_id',
        'amount',
        'remark'
        ];
}
