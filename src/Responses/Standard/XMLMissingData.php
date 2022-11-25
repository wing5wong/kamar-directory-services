<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractXMLResponse;

class XMLMissingData extends AbstractXMLResponse
{
    protected int $error = 400;
    protected string $result = "Bad Request";
}
