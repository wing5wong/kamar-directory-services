<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Recognition extends Model
{
    protected $fillable = [
        "student_id",
        "nsn",
        "uuid",
        "date",
        "slot",
        "term",
        "week",
        "subject",
        "user",
        "points",
        "comment",
        "values"
    ];

    protected $casts = [
        'values' => 'array',
        'date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
