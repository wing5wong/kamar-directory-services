<?php

namespace Wing5wong\KamarDirectoryServices;

use Exception;

class KamarDataException extends Exception
{
    public $data;

    function __construct()
    {
        $this->data = config('kamar-directory-services.serviceName');
    }
}
