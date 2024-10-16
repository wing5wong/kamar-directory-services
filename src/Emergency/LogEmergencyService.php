<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

class LogEmergencyService extends AbstractEmergencyService
{

    public function notify($data)
    {
        info($data);
    }
}
