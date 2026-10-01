<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

use Carbon\Carbon;

class AttendanceDayData
{
    public function __construct(
        public string $date,
        public string $codes,
        public string $alt,
        public ?int $hdu,
        public ?int $hdj,
        public ?int $hdp
    ) {
        $this->date = Carbon::createFromFormat('Ymd', $this->date)->toDateString();
        $this->hdu = $this->hdu ?? 0;
        $this->hdp = $this->hdp ?? 0;
        $this->hdj = $this->hdj ?? 0;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['date'],
            $data['codes'],
            $data['alt'],
            $data['hdu'] ?? 0,
            $data['hdj'] ?? 0,
            $data['hdp'] ?? 0
        );
    }

    public function toArray(): array
    {
        return [
            'date' => $this->date,
            'codes' => $this->codes,
            'alt' => $this->alt,
            'hdp' => $this->hdp,
            'hdj' => $this->hdj,
            'hdu' => $this->hdu,
        ];
    }
}
