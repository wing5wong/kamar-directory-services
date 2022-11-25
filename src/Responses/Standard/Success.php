<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractResponse;

class Success extends AbstractResponse
{
    protected int $error = 0;
    protected string $result = "OK";
}
