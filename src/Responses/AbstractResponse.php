<?php

namespace Wing5wong\KamarDirectoryServices\Responses;

use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractResponse implements Arrayable
{
    protected string $service;
    protected string $version;
    protected string $countryDataStored;
    protected int $error = 501;
    protected string $result = "Not Implemented";
    protected array $additionalFields = [];

    public function __construct()
    {
        $this->service = config('kamar-directory-services.serviceName');
        $this->version = config('kamar-directory-services.serviceVersion');
        $this->countryDataStored = config('kamar-directory-services.countryDataStored');
    }

    public function toArray()
    {
        return [
            'SMSDirectoryData' => array_merge(
                [
                    'service' => $this->service,
                    'version' => $this->version,
                    'error' => $this->error,
                    'result' => $this->result,
                ],
                $this->additionalFields
            )
        ];
    }
}
