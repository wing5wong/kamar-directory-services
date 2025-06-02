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
        'schoolindex' => 'array',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return $this->attributes["firstname"] . " " . $this->attributes["lastname"];
            }
        );
    }

    protected function originalUUID(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $encoded = $this->attributes["uuid"];
                $hex = '';
                while (bccomp($encoded, '0') > 0) {
                    $hex = dechex((int) bcmod($encoded, '16')) . $hex;
                    $encoded = bcdiv($encoded, '16', 0);
                }
                $hex = str_pad($hex, 32, '0', STR_PAD_LEFT);
                return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split($hex, 4));
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
