<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'uuid',
        'role',
        'schoolindex',
        'nsn',
        'created',
        'uniqueid',
        'accountdisabled',
        'signedagreement',
        'byodinfo',
        'username',
        'firstname',
        'lastname',
        'gender',
        'genderpreferred',
        'gendercode',
        'ethnicityL1',
        'ethnicityL2',
        'ethnicity',
        'iwi',
        'siblinglink',
        'boarder',
        'datebirth',
        'yearlevel',
        'fundinglevel',
        'moetype',
        'ece',
        'ors',
        'esol',
        'languagespoken',
        'tutor',
        'house',
        'whanau',
        'timetabletop',
        'timetablebottom',
        'photocoperid',
        'startschooldate',
        'startingdate',
        'leavingdate',
        'leavingreason',
        'leavingactivity',
        'leavingschools',
        'email',
        'mobile',
        'networkaccess',
        'althomedrive',
        'altdescription',
        'residences',
        'caregivers',
        'groups',
        'awards',
        'datasharing'
    ];

    // Define attributes that should be cast to specific types
    protected $casts = [
        'uuid' => 'uuid',
        'ethnicity' => 'array',
        'iwi' => 'array',
        'timetabletop' => 'array',
        'timetablebottom' => 'array',
        'leavingschools' => 'array',
        'residences' => 'array',
        'caregivers' => 'array',
        'groups' => 'array',
        'awards' => 'array',
        'datasharing' => 'array',
    ];

    public function pastoralRecords()
    {
        return $this->hasMany(Pastoral::class, 'student_id', 'id');
    }

    // One student can have many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'id');
    }
}
