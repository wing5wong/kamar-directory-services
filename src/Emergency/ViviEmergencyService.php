<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Exception;
use Illuminate\Support\Facades\Http;

class ViviEmergencyService extends AbstractEmergencyService
{
    protected $endpoint = 'https://api.vivi.io/api/public/v1/emergencies/trigger';
    private $apiKey;
    protected $emergencyTypeId;

    public function __construct()
    {
        $this->apiKey = config('kamar-directory-services.vivi.apiKey');
        $this->emergencyTypeId = config('kamar-directory-service.vivi.emergencyTypeId');
    }

    public function notify($data)
    {
        $emergencyURL = $this->endpoint . "?key=" . $this->apiKey . "&type=" . $this->emergencyTypeId;

        $response = Http::get($emergencyURL);

        return $response->ok();
    }
}
