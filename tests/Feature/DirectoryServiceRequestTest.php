<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Illuminate\Http\Exceptions\HttpResponseException;
use Wing5wong\KamarDirectoryServices\Responses\Standard\FailedAuthentication;
use Wing5wong\KamarDirectoryServices\Responses\Standard\MissingData;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class DirectoryServiceRequestTest extends TestCase
{
    /***
     * 
     */
    public function test_unauthorised_requests_fail()
    {
        $this->withoutExceptionHandling();
        $this->expectException(HttpResponseException::class);
        $this->postJson('/kamar', []);
    }

    public function test_unauthorised_requests_fail2()
    {
        $response = $this->postJson('/kamar', []);
        $response->assertJson((new FailedAuthentication())->toArray(), true);
    }

    public function test_authorised_requests_allowed()
    {
        $response = $this->postJson('/kamar', [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials()
        ]);
        $response->assertJson((new MissingData())->toArray(), true);
    }

    private function validCredentials()
    {
        return "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'));
    }
}
