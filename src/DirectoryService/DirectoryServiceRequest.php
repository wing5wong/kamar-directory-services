<?php

namespace Wing5wong\KamarDirectoryServices\DirectoryService;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Wing5wong\KamarDirectoryServices\Auth\AuthenticationCheck;
use Wing5wong\KamarDirectoryServices\Responses\Standard\FailedAuthentication;
use Wing5wong\KamarDirectoryServices\Responses\Standard\XMLFailedAuthentication;

class DirectoryServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(AuthenticationCheck $authCheck): bool
    {
        return ! $authCheck->fails();
    }

    protected function failedAuthorization()
    {
        if ($this->wantsJson()) {
            throw new HttpResponseException(response()->json((new FailedAuthentication())->toArray()));
        }
        throw new HttpResponseException(response()->xml((string) (new XMLFailedAuthentication())));
    }

    public function rules(): array
    {
        return [
            //'SMSDirectoryData' => 'required'
        ];
    }
}
