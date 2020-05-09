<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'doctor_id',
        'department',
        'created_date',
        'patient_id',
        'body_temp',
        'body_weight',
        'body_height',
        'blood_pressure',
        'result',
    ];

    public function patient(){
        return $this->hasOne(User::class, 'id', 'patient_id');
    }

    public function doctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    public function medicines(){
        return $this->belongsToMany(Medicine::class, 'exam_medicines', 'exam_id', 'medicine_id');
    }

}
