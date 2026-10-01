<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class AttendanceData
{
    /**
     * @param AttendanceDayData[] $values
     */
    public function __construct(
        public int $studentId,
        public string $nsn,
        /** @var AttendanceDayData[] */
        public array $values
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['nsn'],
            collect($data['values'])->map(function ($day): AttendanceDayData {
                return AttendanceDayData::fromArray($day);
            })->all()
        );
    }

    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        return self::fromArray($data);
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
