<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class AttendanceData
{
    public function __construct(
        public int $studentId,
        public string $nsn,
        public array $values
    ) {}

    public static function fromArray($data): self
    {
        return new self(
            $data['id'],
            $data['nsn'],
            collect($data['values'])->map(function ($day) use ($data) {
                return new AttendanceDayData($day['date'], $day['codes'], $day['alt'], $day['hdu'], $day['hdj'], $day['hdp']);
            })->all()
        );
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        return new self(
            $data['id'],
            $data['nsn'],
            array_map(function ($value) {
                return new AttendanceDayData(
                    $value['date'],
                    $value['codes'],
                    $value['alt'],
                    $value['hdu'],
                    $value['hdj'],
                    $value['hdp']
                );
            }, $data['values'])
        );
    }


    public function __toString(): string
    {
        $valuesSummary = array_map(function ($value) {
            return sprintf(
                "[%s: Codes=%s, ALT=%s, HDU=%s, HDJ=%s, HDP=%s]",
                $value->date,
                $value->codes,
                $value->alt,
                $value->hdu,
                $value->hdj,
                $value->hdp
            );
        }, $this->values);

        return sprintf(
            "AttendanceData(Student ID: %d, NSN: %s, Values: %s)",
            $this->studentId,
            $this->nsn,
            implode('; ', $valuesSummary)
        );
    }
}
