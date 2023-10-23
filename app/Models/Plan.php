<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'plan', 'mode_of_payment', 'valid_from_date', 'valid_upto_date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
