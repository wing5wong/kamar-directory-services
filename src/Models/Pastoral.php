<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Pastoral extends Model
{
    // Table name (Laravel uses the plural form by default, so 'pastoral_records' is fine).
    protected $table = 'pastorals';
    protected $with = ['student'];

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

    protected function dayOfWeekEnglish(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->dateevent->englishDayOfWeek;
            }
        );
    }

    protected function dayOfWeek(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->dateevent->dayOfWeek;
            }
        );
    }

    protected function weekOfYear(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->dateevent->weekOfYear;
            }
        );
    }

    protected function monthOfYearEnglish(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->dateevent->monthName;
            }
        );
    }

    protected function monthOfYear(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->dateevent->month;
            }
        );
    }

    protected function period(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $time = Carbon::parse($this->attributes['timeevent'])->format('H:i');

                // Define time ranges and their corresponding labels
                $periods = [
                    ['00:00', '08:39', 'BEFORE SCHOOL'],
                    ['08:40', '09:04', 'FT'],
                    ['09:05', '10:04', 'PERIOD 1'],
                    ['10:05', '11:04', 'PERIOD 2'],
                    ['11:05', '11:49', '1ST BREAK'],
                    ['11:50', '12:49', 'PERIOD 3'],
                    ['12:50', '13:49', 'PERIOD 4'],
                    ['13:50', '14:04', '2ND BREAK'],
                    ['14:05', '15:04', 'PERIOD 5'],
                    ['15:05', '23:59', 'AFTER SCHOOL'],
                ];

                // Iterate through the periods and find a match
                foreach ($periods as [$start, $end, $label]) {
                    if ($time >= $start && $time <= $end) {
                        return $label;
                    }
                }
                return null; // Handle unexpected cases
            }
        );
    }

    // Define the casts for attributes that need type conversion.
    protected $casts = [
        'dateevent' => 'date',
        'timeevent' => 'datetime:H:i:s',
        'datedue' => 'date',
    ];
}
