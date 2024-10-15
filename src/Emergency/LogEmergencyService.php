<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Exception;
use Illuminate\Support\Facades\Http;

class LogEmergencyService extends AbstractEmergencyService
{

    public function notify($data)
    {
        info($data);
    }
}
