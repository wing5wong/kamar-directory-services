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

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    protected $casts = [
        'date' => 'date',
    ];
}
