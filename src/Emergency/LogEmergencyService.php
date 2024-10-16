<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

class LogEmergencyService implements EmergencyServiceInterface
{
    public function notify(KamarEmergencyData $data)
    {
        info('Emergency trigger: ' . $data->message);
    }
}
