<?php

namespace Wing5wong\KamarDirectoryServices\Tests\Feature;

use Illuminate\Http\Response;
use Wing5wong\KamarDirectoryServices\Emergency\EmergencyServiceInterface;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class EmergencyRequestTest extends TestCase
{
    public function test_unauthorised_requests_fail()
    {
        $response = $this->postJson('/kamar/emergency');
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
                'HTTP_AUTHORIZATION' => $this->validCredentials()
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
                'HTTP_AUTHORIZATION' => $this->validCredentials()
            ]
        );

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function missingFieldsProvider()
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

    private function validCredentials()
    {
        return "Basic " . base64_encode(config('kamar-directory-services.username') . ':' . config('kamar-directory-services.password'));
    }

    public function test_emergency_service_notify_called()
    {
        $this->mock(EmergencyServiceInterface::class, function ($mock) {
            $mock->shouldReceive('notify')->once();
        });

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
                'HTTP_AUTHORIZATION' => $this->validCredentials()
            ]
        );

        $response->assertOk();
    }
}
