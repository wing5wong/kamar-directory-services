<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Exception;
use Wing5wong\KamarDirectoryServices\Responses\Standard\FailedAuthentication;
use Wing5wong\KamarDirectoryServices\Responses\Standard\XMLFailedAuthentication;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class DirectoryServiceRequestTest extends TestCase
{
    public function test_unauthorised_requests_throw_exception()
    {
        $this->withoutExceptionHandling();
        $this->expectException(Exception::class);
        $this->post('/kamar', [], [
            'Accept' => 'not-x-m-l-or-json'
        ]);
    }

    public function test_unauthorised_json_requests_return_failed_authentication_response()
    {
        $response = $this->postJson('/kamar');
        $response->assertJson((new FailedAuthentication())->toArray(), true);
    }

    public function test_unauthorised_xml_requests_return_failed_authentication_response()
    {
        $response = $this->post('/kamar', [], [
            'content-type' => 'application/xml'
        ]);
        $this->assertSame((string)(new XMLFailedAuthentication()), $response->getContent());
    }

    public function test_authorised_json_requests_allowed()
    {
        $response = $this->postJson('/kamar', [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ]);

        $response->assertOk();
    }

    public function test_authorised_xml_requests_allowed()
    {
        $response = $this->post('/kamar', [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
            'content-type' => 'application/xml',
        ]);

        $response->assertOk();
    }

    private function validCredentials()
    {
        return "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'));
    }
}
