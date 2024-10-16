<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Illuminate\Support\Facades\Log;

class LogEmergencyService implements EmergencyServiceInterface
{
    public function notify(EmergencyData $data)
    {
        Log::info([
            "message" => $data->message,
            "groupType" => $data->groupType,
            "id" => $data->id,
            "isEmergency" => $data->isEmergency,
            "procedure" => $data->procedure,
            "status" => $data->status,
            "unixTime" => $data->unixTime,
        ]);
    }
}
