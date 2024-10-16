<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Illuminate\Foundation\Http\FormRequest;
use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;

class KamarEmergencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(AuthenticationCheck $authCheck): bool
    {
        return ! $this->authCheck->fails();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'message' => 'required',
            'groupType' => 'required',
            'id' => 'required',
            'isEmergency' => 'required|boolean',
            'procedure' => 'required|in:Evacuate,Lockdown',
            'status' => 'required|in:Alert,Count complete,All Clear',
            'unixTime' => 'required',
        ];
    }

    public function data(): KamarEmergencyData
    {
        return new KamarEmergencyData(
            $this->validated('message'),
            $this->validated('groupType'),
            $this->validated('id'),
            $this->validated('isEmergency'),
            $this->validated('procedure'),
            $this->validated('status'),
            $this->validated('unixTime')
        );
    }
}
