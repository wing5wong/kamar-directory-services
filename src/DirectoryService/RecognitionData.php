<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

use Carbon\Carbon;

class RecognitionData
{
    public function __construct(
        public string $student_id,
        public string $nsn,
        public string $uuid,
        public string $date,
        public ?int $slot,
        public int $term,
        public int $week,
        public string $subject,
        public string $user,
        public int $points,
        public ?string $comment,
        public ?array $values,
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            $data['id'],
            $data['nsn'],
            $data['uuid'],
            $data['date'],
            $data['slot'],
            $data['term'],
            $data['week'],
            $data['subject'],
            $data['user'],
            $data['points'],
            $data['comment'],
            $data['values'],
        );
    }

    public function toArray(): array
    {
        return [
            'student_id' => $this->student_id,
            'nsn' => $this->nsn,
            'uuid' => $this->uuid,
            'date' => Carbon::createFromFormat('Ymd', $this->date),
            'slot' => $this->slot,
            'term' => $this->term,
            'week' => $this->week,
            'subject' => $this->subject,
            'user' => $this->user,
            'points' => $this->points,
            'comment' => $this->comment,
            'values' => $this->values,
        ];
    }
}
