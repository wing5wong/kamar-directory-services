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

    public function __construct()
    {
        parent::__construct();

        $this->infoUrl = config('kamar-directory-services.infoUrl');
        $this->privacyStatement = config('kamar-directory-services.privacyStatement');
        $this->options = config('kamar-directory-services.options');
        
        $this->additionalFields = [
            'status' => $this->status,
            'infourl' => $this->infoUrl,
            'privacystatement' => $this->privacyStatement,
            'options' => $this->options,
        ];
    }
}
