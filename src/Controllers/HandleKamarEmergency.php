<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use Illuminate\Routing\Controller;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyServiceInterface;
use Wing5wong\KamarDirectoryServices\Emergency\KamarEmergencyRequest;

class HandleKamarEmergency extends Controller
{
    public function __construct(
        protected EmergencyServiceInterface $emergencyService
    ) {}

    public function __invoke(KamarEmergencyRequest $request)
    {
        $this->emergencyService->notify($request->data());
    }
}
