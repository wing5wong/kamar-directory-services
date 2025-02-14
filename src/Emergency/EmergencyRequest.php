<?php

namespace Wing5wong\KamarDirectoryServices\Emergency;

use Illuminate\Foundation\Http\FormRequest;
use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;

class EmergencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(AuthenticationCheck $authCheck): bool
    {
        return ! $authCheck->fails();
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
            'groupType' => 'required|in:Tutor group,Current class',
            'id' => 'required',
            'isEmergency' => 'required|boolean',
            'procedure' => 'required|in:Evacuate,Lockdown',
            'status' => 'required|in:Alert,Count complete,All clear,Event over',
            'unixTime' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'groupType.in' => 'Must be one of: tutor group, current class',
            'procedure.in' => 'Must be one of: Evacuate, Lockdown',
            'status.in' => 'Must be one of:Alert, Count complete, All Clear',
        ];
    }
}
