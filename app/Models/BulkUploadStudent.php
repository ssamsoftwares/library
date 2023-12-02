<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkUploadStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','created_by','phone_number','email','address','course','graduation','remark'
    ];


    public function createbyStudent()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


}
