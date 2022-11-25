<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractResponse;

class FailedAuthentication extends AbstractResponse
{
    protected int $error = 403;
    protected string $result = "Forbidden";
}
