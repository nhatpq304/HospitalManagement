<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'remark',
        'start_time',
        'end_time'
    ];

    public function patient(){
        return $this->hasOne(User::class, 'id', 'patient_id');
    }

    public function doctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
