<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Model;

class Pastoral extends Model
{
    // Table name (Laravel uses the plural form by default, so 'pastoral_records' is fine).
    protected $table = 'pastorals';

    // Define fillable attributes (mass assignable attributes).
    protected $fillable = [
        'student_id',
        'nsn',
        'type',
        'ref',
        'reason',
        'reasonPB',
        'motivation',
        'motivationPB',
        'location',
        'locationPB',
        'othersinvolved',
        'action1',
        'action2',
        'action3',
        'actionPB1',
        'actionPB2',
        'actionPB3',
        'teacher',
        'points',
        'demerits',
        'dateevent',
        'timeevent',
        'datedue',
        'duestatus',
    ];

    // Define relationships (if needed, such as student relationship).
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Define the casts for attributes that need type conversion.
    protected $casts = [
        'dateevent' => 'date',
        'timeevent' => 'datetime:H:i:s',
        'datedue' => 'date',
    ];
}
