<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Exception;
use Wing5wong\KamarDirectoryServices\Responses\Standard\FailedAuthentication;
use Wing5wong\KamarDirectoryServices\Responses\Standard\XMLFailedAuthentication;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class DirectoryServiceRequestTest extends TestCase
{
    public function test_wrong_accept_header_throws_exception()
    {
        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->post(route('kamar'), [], [
            'Accept' => 'not-x-m-l-or-json'
        ]);
    }

    public function test_unauthorised_json_requests_return_failed_authentication_response()
    {
        $response = $this->postJson(route('kamar'));
        $response->assertJson((new FailedAuthentication())->toArray(), true);
    }

    public function test_json_requests_with_invalid_credentials()
    {
        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->invalidCredentials(),
        ])->postJson(route('kamar'));

        $response->assertJson((new FailedAuthentication())->toArray());
    }

    public function test_unauthorised_xml_requests_return_failed_authentication_response()
    {
        $response = $this->post(route('kamar'), [], [
            'content-type' => 'application/xml'
        ]);
        $this->assertSame((string)(new XMLFailedAuthentication()), $response->getContent());
    }

    public function test_xml_requests_with_invalid_credentials()
    {
        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->invalidCredentials(),
            'content-type' => 'application/xml'
        ])->post(route('kamar'));

        $this->assertSame((string)(new XMLFailedAuthentication()), $response->getContent());
    }

    public function test_authorised_json_requests_allowed()
    {
        $response = $this->postJson(route('kamar'), [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ]);

        $response->assertOk();
    }

    public function test_authorised_xml_requests_allowed()
    {
        $response = $this->post(route('kamar'), [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
            'content-type' => 'application/xml',
        ]);

        $response->assertOk();
    }

    private function validCredentials()
    {
        return "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'));
    }

    private function invalidCredentials()
    {
        return "Basic " . base64_encode('username' . ':' . 'password');
    }
}
