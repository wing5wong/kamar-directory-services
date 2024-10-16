<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

interface EmergencyServiceInterface
{
    public function notify(EmergencyData $data);
}
