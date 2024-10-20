<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use Illuminate\Routing\Controller;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyData;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyServiceInterface;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyRequest;

class HandleEmergency extends Controller
{
    public function __construct(
        protected EmergencyServiceInterface $emergencyService
    ) {}

    public function __invoke(EmergencyRequest $request)
    {
        $this->emergencyService->notify(EmergencyData::fromRequest($request));
    }
}
