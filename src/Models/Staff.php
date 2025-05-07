<?php

namespace Wing5wong\KamarDirectoryServices\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Wing5wong\KamarDirectoryServices\DirectoryService\StaffData;

class Staff extends Model
{
    protected $fillable = [
        'staff_id',
        'uuid',
        'role',
        'schoolindex',
        'created',
        'uniqueid',
        'username',
        'title',
        'firstname',
        'lastname',
        'gender',
        'datebirth',
        'classification',
        'position',
        'tutor',
        'house',
        'registrationnumber',
        'moenumber',
        'startingdate',
        'leavingdate',
        'photocoperid',
        'email',
        'mobile',
        'extension',
        'groups',
    ];

    // Define attributes that should be cast to specific types
    protected $casts = [
        'groups' => 'array',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->attributes["firstname"] . " " . $this->attributes["lastname"];
            }
        );
    }

    protected function departmentGroups(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return collect($this->attributes["groups"])->filter(function ($group) {
                    return $group['type'] === 'department' && str_starts_with($group['name'], StaffData::DEPARTMENT_PREFIX);
                })->each(function ($group) {
                    $group['name'] = Str::after($group['name'], StaffData::DEPARTMENT_PREFIX);
                });
            }
        );
    }

    protected function classificationGroups(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return collect($this->attributes["groups"])->filter(function ($group) {
                    return $group['type'] === 'department' && str_starts_with($group['name'], StaffData::CLASSIFICATION_PREFIX);
                })->each(function ($group) {
                    $group['name'] = Str::after($group['name'], StaffData::CLASSIFICATION_PREFIX);
                });
            }
        );
    }

    protected function classGroups(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return collect($this->attributes["groups"])
                    ->filter(fn($group) => $group['type'] === 'class')
                    ->map(fn($group) => "{$group['subject']}-{$group['coreoption']}");
            }
        );
    }
}
