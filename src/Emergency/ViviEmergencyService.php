<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Exception;
use Illuminate\Support\Facades\Http;

class ViviEmergencyService extends AbstractEmergencyService
{
    protected $endpoint = 'https://api.vivi.io/api/public/v1/emergencies/trigger';
    private $apiKey;
    protected $emergencyTypeId = "51c97eea-bc65-4d44-8949-8ba2a1226e27";

    public function __construct()
    {
        $this->apiKey = config('kamar-directory-services.vivi.apiKey');
    }

    public function notify($data)
    {
        $emergencyURL = $this->endpoint . "?key=" . $this->apiKey . "&type=" . $this->emergencyTypeId;
        // &location=a72f5381-9872-41a4-990e-bf42f17802aa" -- library

        try {
            $response = Http::get($emergencyURL);
            return $response->ok();
        } catch (Exception $e) {
        }
    }
}
