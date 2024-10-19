<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Unit;

use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;
use Illuminate\Http\Request;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class AuthenticationCheckTest extends TestCase
{
    public function test_invalid_credentials()
    {
        $request = new Request();
        $request->server->replace(['HTTP_AUTHORIZATION' => "Basic " . base64_encode('username' . ':' . 'password')]);
        app()->instance('request', $request);

        $this->assertTrue((new AuthenticationCheck())->fails());
    }

    public function test_valid_credentials()
    {
        $request = new Request();
        $request->server->replace(['HTTP_AUTHORIZATION' => "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'))]);
        app()->instance('request', $request);

        $this->assertFalse((new AuthenticationCheck())->fails());
    }
}
