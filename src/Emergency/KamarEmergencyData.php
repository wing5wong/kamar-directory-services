<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

class KamarEmergencyData
{
    public function __construct(
        public string $message,
        public string $groupType,
        public string $id,
        public bool $isEmergency,
        public string $procedure,
        public string $status,
        public int $unixTime,
    ) {}
}
