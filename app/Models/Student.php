<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;


class Student extends Model implements Authenticatable
{
    use HasFactory,AuthenticatableTrait;

    protected $fillable = ['user_id','name', 'email','password', 'personal_number', 'emergency_number', 'dob', 'course', 'current_address', 'permanent_address', 'subscription', 'remark_singnature', 'hall_number', 'vehicle_number', 'aadhar_number', 'aadhar_front_img', 'aadhar_back_img', 'image','status','payment','pending_payment'];

    public function plan()
    {
        return $this->hasOne(Plan::class);
    }

    public function createby()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
