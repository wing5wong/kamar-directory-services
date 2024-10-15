<?php

namespace Wing5wong\KamarDirectoryServices\Controllers;

use Illuminate\Routing\Controller;
use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyServiceInterface;
use Wing5wong\KamarDirectoryServices\Responses\Standard\FailedAuthentication;

class HandleKamarEmergency extends Controller
{
    public function __construct(
        protected AuthenticationCheck $authCheck,
        protected EmergencyServiceInterface $emergencyService
    ) {}

    public function __invoke()
    {
        // Check supplied username/password matches our expectation
        if ($this->authCheck->fails()) {
            return response()->json(new FailedAuthentication());
        }

        $this->emergencyService->notify(request()->input());
    }
}
