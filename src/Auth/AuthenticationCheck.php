<?php

namespace Wing5wong\KamarDirectoryServices\Auth;

class AuthenticationCheck
{
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->username = config('kamar-directory-services.username');
        $this->password = config('kamar-directory-services.password');
    }

    public function fails()
    {
        return request()->server('HTTP_AUTHORIZATION') !== ("Basic " . base64_encode($this->username . ':' . $this->password));
    }
}
