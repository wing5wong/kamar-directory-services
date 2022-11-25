<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractXMLResponse;

class XMLFailedAuthentication extends AbstractXMLResponse
{
    protected int $error = 403;
    protected string $result = "Forbidden";
}
