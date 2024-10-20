<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Illuminate\Auth\Access\AuthorizationException;
use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyData;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyRequest;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class EmergencyRequestTest extends TestCase
{
    public function test_unauthorised_requests_fail()
    {
        $response = $this->postJson('/kamar/emergency', []);
        $response->assertForbidden();
    }

    public function test_requires_valid_fields()
    {
        $response = $this->postJson(
            '/kamar/emergency',
            [
                'message' => 'required',
                'groupType' => 'tutor group',
                'id' => 'required',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'status' => 'Alert',
                'unixTime' => 123456789,
            ],
            [
                'HTTP_AUTHORIZATION' => "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'))
            ]
        );

        $response->assertOk();
    }

    /**
     * @dataProvider missingFieldsProvider()
     */
    public function test_requires_valid_fields_redirect_if_missing($fields)
    {
        $response = $this->postJson(
            '/kamar/emergency',
            $fields,
            [
                'HTTP_AUTHORIZATION' => "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'))
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function missingFieldsProvider()
    {
        return [
            [[
                'groupType' => 'tutor group',
                'id' => 'required',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'status' => 'Alert',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'id' => 'required',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'status' => 'Alert',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'groupType' => 'tutor group',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'status' => 'Alert',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'groupType' => 'tutor group',
                'id' => 'required',
                'procedure' => 'Lockdown',
                'status' => 'Alert',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'groupType' => 'tutor group',
                'id' => 'required',
                'isEmergency' => true,
                'status' => 'Alert',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'groupType' => 'tutor group',
                'id' => 'required',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'unixTime' => 123456789,
            ]],
            [[
                'message' => 'Emergency',
                'groupType' => 'tutor group',
                'id' => 'required',
                'isEmergency' => true,
                'procedure' => 'Lockdown',
                'status' => 'Alert',
            ]],
        ];
    }
}
