<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

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
        return $this->hasMany(Pastoral::class, 'student_id', 'student_id');
    }

    // One student can have many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'student_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->attributes["firstname"] . " " . $this->attributes["lastname"];
            }
        );
    }

    private function base36_decode(string $base36): string
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $base36 = strtoupper(rtrim($base36, '='));
        $binary = '';
        $buffer = 0;
        $bufferLength = 0;

        // Decode the base36 string
        for ($i = 0; $i < strlen($base36); $i++) {
            $index = strpos($alphabet, $base36[$i]);
            if ($index === false) {
                throw new InvalidArgumentException("Invalid base36 character: " . $base36[$i]);
            }

            // Add the index value to the buffer
            $buffer = ($buffer << 5) | $index;
            $bufferLength += 5;

            // Extract full bytes from the buffer
            while ($bufferLength >= 8) {
                $bufferLength -= 8;
                $binary .= chr(($buffer >> $bufferLength) & 255); // Extract the next byte
            }
        }

        return bin2hex($binary);
    }

    protected function originalUUID(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($this->base36_decode($this->attributes['uuid']), 4));;
            }
        );
    }
}
