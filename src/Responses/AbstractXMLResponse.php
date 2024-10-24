<?php

namespace Wing5wong\KamarDirectoryServices\Responses;

use Stringable;
use Spatie\ArrayToXml\ArrayToXml;

abstract class AbstractXMLResponse implements Stringable
{
    protected string $service;
    protected string $version;
    protected int $error = 501;
    protected string $result = "Not Implemented";
    protected array $additionalFields = [];

    public function __construct()
    {
        $this->service = config('kamar-directory-services.serviceName');
        $this->version = config('kamar-directory-services.serviceVersion');
    }

    public function __toString()
    {
        return ArrayToXml::convert(
            array_merge(
                [
                    'service' => $this->service,
                    'version' => $this->version,
                    'error' => $this->error,
                    'result' => $this->result,
                ],
                $this->additionalFields
            ),
            'SMSDirectoryData'
        );
    }
}
