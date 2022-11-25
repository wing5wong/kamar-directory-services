<?php

namespace Wing5wong\KamarDirectoryServices\Responses\Standard;

use Wing5wong\KamarDirectoryServices\Responses\AbstractResponse;

class MissingData extends AbstractResponse
{
    protected int $error = 400;
    protected string $result = "Bad Request";
}
