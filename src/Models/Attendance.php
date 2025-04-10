<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'nsn',
        'date',
        'codes',
        'alt',
        'hdu',
        'hdj',
        'hdp',
    ];

    // Define the relationship with the student (assuming the Student model exists).
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
