<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class StaffData
{
    public function __construct(
        public string $staff_id, // staff code e.g. ANS
        public string $role = 'Staff',
        public ?string $uuid,
        public ?int $schoolindex,
        public ?string $created,
        public ?string $uniqueid,
        public ?string $username,
        public ?string $title,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $gender,
        public ?string $datebirth,
        public ?string $classification,
        public ?string $position,
        public ?string $tutor,
        public ?string $house,
        public ?string $startingdate,
        public ?string $leavingdate,
        public ?string $photocoperid,
        public ?string $email,
        public ?string $mobile,
        public ?array $groups,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            staff_id: $data['id'],
            uuid: $data['uuid'] ?? null,
            schoolindex: $data['schoolindex'] ?? null,
            created: $data['created'] ?? null,
            uniqueid: $data['uniqueid'] ?? null,
            username: $data['username'] ?? null,
            title: $data['title'] ?? null,
            firstname: $data['firstname'] ?? null,
            lastname: $data['lastname'] ?? null,
            gender: $data['gender'] ?? null,
            datebirth: $data['datebirth'] ?? null,
            classification: $data['classification'] ?? null,
            position: $data['position'] ?? null,
            tutor: $data['tutor'] ?? null,
            house: $data['house'] ?? null,
            startingdate: $data['startingdate'] ?? null,
            leavingdate: $data['leavingdate'] ?? null,
            photocoperid: $data['photocoperid'] ?? null,
            email: $data['email'] ?? null,
            mobile: $data['mobile'] ?? null,
            groups: $data['groups'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'staff_id' => $this->staff_id,
            'role' => $this->role,
            'uuid' => $this->uuid,
            'schoolindex' => $this->schoolindex,
            'created' => $this->created,
            'uniqueid' => $this->uniqueid,
            'username' => $this->username,
            'title' => $this->title,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'datebirth' => $this->datebirth,
            'classification' => $this->classification,
            'position' => $this->position,
            'tutor' => $this->tutor,
            'house' => $this->house,
            'photocoperid' => $this->photocoperid,
            'startingdate' => $this->startingdate,
            'leavingdate' => $this->leavingdate,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'groups' => $this->groups,
        ];
    }
}
