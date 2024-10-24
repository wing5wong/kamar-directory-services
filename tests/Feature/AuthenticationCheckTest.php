<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;
use Illuminate\Http\Request;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class AuthenticationCheckTest extends TestCase
{
    public function test_no_credentials()
    {
        $request = new Request();
        $this->assertTrue((new AuthenticationCheck($request))->fails());
    }

    public function test_invalid_credentials()
    {
        $request = new Request();
        $request->server->replace(['HTTP_AUTHORIZATION' => "Basic " . base64_encode('username' . ':' . 'password')]);

        $this->assertTrue((new AuthenticationCheck($request))->fails());
    }

    public function test_valid_credentials()
    {
        $request = new Request();
        $request->server->set('HTTP_AUTHORIZATION',  "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password')));

        $this->assertFalse((new AuthenticationCheck($request))->fails());
    }
}
