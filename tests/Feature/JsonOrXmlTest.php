<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Exception;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class JsonOrXmlTest extends TestCase
{
    public function test_wrong_accept_header_throws_exception()
    {
        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->withHeader('Accept', 'not-x-m-l-or-json')->post('/');
    }
}
