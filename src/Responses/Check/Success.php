<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Check;

use Wing5wong\KamarDirectoryServices\Responses\AbstractResponse;

class Success extends AbstractResponse
{
    protected int $error = 0;
    protected string $result = "OK";
    protected string $status = "Ready";
    protected string $infoUrl;
    protected string $privacyStatement;
    protected array $options;
    protected string $authSuffix;

    public function __construct($dateTime = null, $buildNumber = null)
    {
        parent::__construct();

        $this->infoUrl = config('kamar-directory-services.infoUrl');
        $this->privacyStatement = config('kamar-directory-services.privacyStatement');
        $this->options = config('kamar-directory-services.options');
        $this->authSuffix = config('kamar-directory-services.authSuffix');

        $this->additionalFields = [
            'status' => $this->status,
            'infourl' => $this->infoUrl,
            'privacystatement' => $this->privacyStatement,
            'options' => $this->options,
        ];

        if ($this->authSuffix && $dateTime && $buildNumber) {
            $this->additionalFields['authtoken'] = md5($dateTime . $buildNumber . $this->service . $this->infoUrl . $this->authSuffix);
        }
    }
}
