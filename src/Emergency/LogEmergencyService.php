<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

class LogEmergencyService implements EmergencyServiceInterface
{
    public function notify(EmergencyData $data)
    {
        info([
            $data->message,
            $data->groupType,
            $data->id,
            $data->isEmergency,
            $data->procedure,
            $data->status,
            $data->unixTime,
        ]);
    }
}
