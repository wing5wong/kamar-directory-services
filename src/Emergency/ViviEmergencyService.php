<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Exception;
use Illuminate\Support\Facades\Http;

class ViviEmergencyService implements EmergencyServiceInterface
{
    // todo: base endpoint should be 'https://api.vivi.io/api/public/v1/emergencies/'
    // second value based on type - 'trigger' or 'cancel'
    protected $endpoints = [
        'trigger' =>     'https://api.vivi.io/api/public/v1/emergencies/trigger',
        'cancel' => 'https://api.vivi.io/api/public/v1/emergencies/cancel',
    ];

    private $apiKey;
    protected $emergencyTypeId;

    public function __construct()
    {
        $this->apiKey = config('kamar-directory-services.vivi.apiKey');
        $this->emergencyTypeId = config('kamar-directory-services.vivi.emergencyTypeId');
    }

    public function notify(EmergencyData $data)
    {
        $type = $data->isEmergencyCompletion() ? 'cancel' : 'trigger';
        $emergencyURL = $this->endpoints[$type] . "?key=" . $this->apiKey . "&type=" . $this->emergencyTypeId;

        $response = Http::get($emergencyURL);

        return $response->ok();
    }
}
