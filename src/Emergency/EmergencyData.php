<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

class EmergencyData
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

    public static function fromRequest(EmergencyRequest $request): EmergencyData
    {
        return new static(
            $request->validated('message'),
            $request->validated('groupType'),
            $request->validated('id'),
            $request->validated('isEmergency'),
            $request->validated('procedure'),
            $request->validated('status'),
            $request->validated('unixTime')
        );
    }
}
