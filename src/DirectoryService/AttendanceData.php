<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class AttendanceData
{
    public function __construct(
        public int $id,
        public string $nsn,
        public array $values
    ) {}

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
}
