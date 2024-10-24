<?php

namespace Wing5wong\KamarDirectoryServices\Auth;

use Illuminate\Http\Request;

class AuthenticationCheck
{
    private Request $request;
    private string $username;
    private string $password;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->username = config('kamar-directory-services.username');
        $this->password = config('kamar-directory-services.password');
    }

    public function fails()
    {
        return $this->request->server('HTTP_AUTHORIZATION') !== ("Basic " . base64_encode($this->username . ':' . $this->password));
    }
}
