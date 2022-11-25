<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractXMLResponse;

class XMLSuccess extends AbstractXMLResponse

{
    protected int $error = 0;
    protected string $result = "OK";
}
