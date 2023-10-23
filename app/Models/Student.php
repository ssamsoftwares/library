<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'personal_number', 'emergency_number', 'dob', 'course', 'current_address', 'permanent_address', 'subscription', 'remark_singnature', 'hall_number', 'vehicle_number', 'aadhar_number', 'aadhar_front_img', 'aadhar_back_img', 'image'];

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

}
