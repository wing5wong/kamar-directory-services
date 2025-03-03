<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

use Carbon\Carbon;

class PastoralData
{
    public function __construct(
        public string $student_id,
        public string $nsn,
        public string $type,
        public int $ref,
        public string $reason,
        public ?string $reasonPB,
        public ?string $motivation,
        public ?string $motivationPB,
        public ?string $location,
        public ?string $locationPB,
        public ?string $othersinvolved,
        public string $action1,
        public ?string $action2,
        public ?string $action3,
        public ?string $actionPB1,
        public ?string $actionPB2,
        public ?string $actionPB3,
        public string $teacher,
        public ?int $points,
        public ?int $demerits,
        public string $dateevent,
        public string $timeevent,
        public string $datedue,
        public ?string $duestatus,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            $data->id,
            $data->nsn,
            $data->type,
            $data->ref,
            $data->reason,
            $data->reasonPB,
            $data->motivation,
            $data->motivationPB,
            $data->location,
            $data->locationPB,
            $data->othersinvolved,
            $data->action1,
            $data->action2,
            $data->action3,
            $data->actionPB1,
            $data->actionPB2,
            $data->actionPB3,
            $data->teacher,
            $data->points,
            $data->demerits,
            $data->dateevent,
            $data->timeevent,
            $data->datedue,
            $data->duestatus,
        );
    }

    public function toArray(): array
    {
        return [
            'student_id' => $this->student_id,
            'nsn' => $this->nsn,
            'type' => $this->type,
            'ref' => $this->ref,
            'reason' => $this->reason,
            'reasonPB' => $this->reasonPB,
            'motivation' => $this->motivation,
            'motivationPB' => $this->motivationPB,
            'location' => $this->location,
            'locationPB' => $this->locationPB,
            'othersinvolved' => $this->othersinvolved,
            'action1' => $this->action1,
            'action2' => $this->action2,
            'action3' => $this->action3,
            'actionPB1' => $this->actionPB1,
            'actionPB2' => $this->actionPB2,
            'actionPB3' => $this->actionPB3,
            'teacher' => $this->teacher,
            'points' => $this->points,
            'demerits' => $this->demerits,
            'dateevent' =>  Carbon::createFromFormat('Ymd', $this->dateevent),
            'timeevent' => Carbon::createFromFormat('His', $this->timeevent),
            'datedue' => $this->datedue === "00000000" ? null : Carbon::createFromFormat('Ymd', $this->datedue),
            'duestatus' => $this->duestatus,
        ];
    }
}
