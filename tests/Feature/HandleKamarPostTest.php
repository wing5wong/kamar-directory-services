<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Illuminate\Support\Facades\Storage;
use Wing5wong\KamarDirectoryServices\KamarData;
use Wing5wong\KamarDirectoryServices\Responses\Standard\Success;
use Wing5wong\KamarDirectoryServices\Responses\Check\Success as CheckSuccess;
use Wing5wong\KamarDirectoryServices\Responses\Standard\MissingData;
use Wing5wong\KamarDirectoryServices\Responses\Standard\XMLMissingData;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class HandleKamarPostTest extends TestCase
{

    public function test_json_request_with_missing_data()
    {
        $response = $this->validJsonCredentialRequest();
        $response->assertJson((new MissingData())->toArray(), true);
    }

    public function test_xml_request_with_missing_data()
    {
        $response = $this->validXMLCredentialRequest();
        $this->assertSame((string)(new XMLMissingData()), $response->getContent());
    }

    public function test_authenticated_standard_requests_with_blank_data_return_400()
    {
        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->postJson(route('kamar'));

        $response->assertJson((new MissingData())->toArray());
    }

    public function test_authenticated_standard_requests_with_empty_data_return_400()
    {
        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->postJson(route('kamar'), []);

        $response->assertJson((new MissingData())->toArray());
    }




    public function test_authenticated_standard_xml_requests_with_blank_data_return_400()
    {
        $response = $this->withHeaders([
            'content-type' => 'application/xml',
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->post(route('kamar'));

        $response->assertSee((string) (new XMLMissingData()), false);
    }

    public function test_authenticated_standard_xml_requests_with_empty_data_return_400()
    {
        $response = $this->withHeaders([
            'content-type' => 'application/xml',
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->post(route('kamar'));

        $response->assertSee((string) (new XMLMissingData()), false);
    }

    public function test_authenticated_check_requests_return_success()
    {
        $version = "2198";
        $datetime = "20221122111106";

        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->postJson(
            route('kamar'),
            [
                'SMSDirectoryData' => [
                    'sync' => 'check',
                    "version" => $version,
                    "datetime" => $datetime
                ]
            ]
        );

        $response->assertJson((new CheckSuccess($datetime, $version))->toArray());
    }

    public function test_authenticated_standard_requests_return_success()
    {
        $response = $this->withHeaders([
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
        ])->postJson(
            route('kamar'),
            ['SMSDirectoryData' => ['sync' => 'part']]
        );

        $response->assertJson((new Success())->toArray());
    }





    public function test_it_tries_to_store_the_part_file()
    {
        Storage::shouldReceive('disk->put')->once()->andReturn(true);

        $this->postJson(
            '/kamar',
            ['SMSDirectoryData' => ['sync' => KamarData::SYNC_TYPE_PART]],
            [
                'content-type' => 'application/json',
                'HTTP_AUTHORIZATION' => "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'))
            ]
        );
    }

    public function test_it_stores_a_part_file()
    {
        Storage::fake(config('kamar-directory-services.storageDisk'));

        $this->postJson(
            '/kamar',
            ['SMSDirectoryData' => ['sync' => KamarData::SYNC_TYPE_PART]],
            [
                'content-type' => 'application/json',
                'HTTP_AUTHORIZATION' => "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'))
            ]
        );

        $this->assertFalse(
            empty(Storage::disk(config('kamar-directory-services.storageDisk'))->allFiles(config('kamar-directory-services.storageFolder')))
        );
    }

    private function validCredentials()
    {
        return "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'));
    }

    private function validJsonCredentialRequest()
    {
        return $this->postJson('/kamar', [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials()
        ]);
    }

    private function validXMLCredentialRequest()
    {
        return $this->post('/kamar', [], [
            'HTTP_AUTHORIZATION' => $this->validCredentials(),
            'content-type' => 'application/xml'
        ]);
    }
}
