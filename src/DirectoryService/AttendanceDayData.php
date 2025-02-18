<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

class AttendanceDayData
{
    public function __construct(
        public string $date,
        public string $codes,
        public string $alt,
        public int $hdu,
        public int $hdj,
        public int $hdp
    ) {}
}
