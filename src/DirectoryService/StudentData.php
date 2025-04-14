<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class StudentData
{
    public function __construct(
        public string $student_id,
        public string $role = 'Student',
        public ?string $uuid,
        public ?int $schoolindex,
        public ?string $nsn,
        public ?string $created,
        public ?string $uniqueid,
        public ?bool $accountdisabled = false,
        public ?bool $signedagreement = true,
        public ?string $byodinfo,
        public ?string $username,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $gender,
        public ?string $genderpreferred,
        public ?string $gendercode,
        public ?string $ethnicityL1,
        public ?string $ethnicityL2,
        public ?array $ethnicity,
        public ?array $iwi,
        public ?string $siblinglink,
        public ?bool $boarder = false,
        public ?string $datebirth,
        public ?int $yearlevel,
        public ?int $fundinglevel,
        public ?string $moetype,
        public ?string $ece,
        public ?string $ors,
        public ?bool $esol = false,
        public ?string $languagespoken,
        public ?string $tutor,
        public ?string $house,
        public ?string $whanau,
        public ?array $timetabletop,
        public ?array $timetablebottom,
        public ?string $photocopierid,
        public ?string $startschooldate,
        public ?string $startingdate,
        public ?string $leavingdate,
        public ?string $leavingreason,
        public ?string $leavingactivity,
        public ?array $leavingschools,
        public ?string $email,
        public ?string $mobile,
        public ?bool $networkaccess = true,
        public ?string $althomedrive,
        public ?string $altdescription,
        public ?array $residence,
        public ?array $caregivers,
        public ?array $groups,
        public ?array $awards,
        public ?array $datasharing,
        public ?string $passwordencrypted,
        public ?bool $resetpassword = false,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            student_id: $data['id'],
            uuid: $data['uuid'] ?? null,
            schoolindex: $data['schoolindex'] ?? null,
            nsn: $data['nsn'] ?? null,
            created: $data['created'] ?? null,
            uniqueid: $data['uniqueid'] ?? null,
            accountdisabled: (bool)($data['accountdisabled'] ?? false),
            signedagreement: (bool)($data['signedagreement'] ?? true),
            byodinfo: $data['byodinfo'] ?? null,
            username: $data['username'] ?? null,
            firstname: $data['firstname'] ?? null,
            lastname: $data['lastname'] ?? null,
            gender: $data['gender'] ?? null,
            genderpreferred: $data['genderpreferred'] ?? null,
            gendercode: $data['gendercode'] ?? null,
            ethnicityL1: $data['ethnicityL1'] ?? null,
            ethnicityL2: $data['ethnicityL2'] ?? null,
            ethnicity: $data['ethnicity'] ?? null,
            iwi: $data['iwi'] ?? null,
            siblinglink: $data['siblinglink'] ?? null,
            boarder: (bool)($data['boarder'] ?? false),
            datebirth: $data['datebirth'] ?? null,
            yearlevel: $data['yearlevel'] ?? null,
            fundinglevel: $data['fundinglevel'] ?? null,
            moetype: $data['moetype'] ?? null,
            ece: $data['ece'] ?? null,
            ors: $data['ors'] ?? null,
            esol: (bool)($data['esol'] ?? false),
            languagespoken: $data['languagespoken'] ?? null,
            tutor: $data['tutor'] ?? null,
            house: $data['house'] ?? null,
            whanau: $data['whanau'] ?? null,
            timetabletop: $data['timetabletop'] ?? null,
            timetablebottom: $data['timetablebottom'] ?? null,
            photocopierid: $data['photocopierid'] ?? null,
            startschooldate: $data['startschooldate'] ?? null,
            startingdate: $data['startingdate'] ?? null,
            leavingdate: $data['leavingdate'] ?? null,
            leavingreason: $data['leavingreason'] ?? null,
            leavingactivity: $data['leavingactivity'] ?? null,
            leavingschools: $data['leavingschools'] ?? null,
            email: $data['email'] ?? null,
            mobile: $data['mobile'] ?? null,
            networkaccess: (bool)($data['networkaccess'] ?? true),
            althomedrive: $data['althomedrive'] ?? null,
            altdescription: $data['altdescription'] ?? null,
            residence: $data['residence'] ?? null,
            caregivers: $data['caregivers'] ?? null,
            groups: $data['groups'] ?? null,
            awards: $data['awards'] ?? null,
            datasharing: $data['datasharing'] ?? null,
            passwordencrypted: $data['passwordencrypted'] ?? null,
            resetpassword: (bool)($data['resetpassword'] ?? false),
        );
    }
    public function toArray(): array
    {
        return [
            'student_id' => $this->student_id,
            'role' => $this->role,
            'uuid' => $this->uuid,
            'schoolindex' => $this->schoolindex,
            'nsn' => $this->nsn,
            'created' => $this->created,
            'uniqueid' => $this->uniqueid,
            'accountdisabled' => $this->accountdisabled,
            'signedagreement' => $this->signedagreement,
            'byodinfo' => $this->byodinfo,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'genderpreferred' => $this->genderpreferred,
            'gendercode' => $this->gendercode,
            'ethnicityL1' => $this->ethnicityL1,
            'ethnicityL2' => $this->ethnicityL2,
            'ethnicity' => $this->ethnicity,
            'iwi' => $this->iwi,
            'siblinglink' => $this->siblinglink,
            'boarder' => $this->boarder,
            'datebirth' => $this->datebirth,
            'yearlevel' => $this->yearlevel,
            'fundinglevel' => $this->fundinglevel,
            'moetype' => $this->moetype,
            'ece' => $this->ece,
            'ors' => $this->ors,
            'esol' => $this->esol,
            'languagespoken' => $this->languagespoken,
            'tutor' => $this->tutor,
            'house' => $this->house,
            'whanau' => $this->whanau,
            'timetabletop' => $this->timetabletop,
            'timetablebottom' => $this->timetablebottom,
            'photocopierid' => $this->photocopierid,
            'startschooldate' => $this->startschooldate,
            'startingdate' => $this->startingdate,
            'leavingdate' => $this->leavingdate,
            'leavingreason' => $this->leavingreason,
            'leavingactivity' => $this->leavingactivity,
            'leavingschools' => $this->leavingschools,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'networkaccess' => $this->networkaccess,
            'althomedrive' => $this->althomedrive,
            'altdescription' => $this->altdescription,
            'residence' => $this->residence,
            'caregivers' => $this->caregivers,
            'groups' => $this->groups,
            'awards' => $this->awards,
            'datasharing' => $this->datasharing,
        ];
    }
}
