<?php

namespace Wing5wong\KamarDirectoryServices\Encryption;

class KamarEncrypter implements KamarEncryptionInterface
{
    private $algorithm;
    private $key;

    public function __construct()
    {
        $this->algorithm = config("kamar-directory-services.encryptionAlgorithm");
        $this->key = config("kamar-directory-services.encryptionKey");
    }

    public function encrypt(string $string): string|false
    {
        return openssl_encrypt($string, $this->algorithm, $this->key);
    }

    public function decrypt(string $string): string|false
    {
        return openssl_decrypt($string, $this->algorithm, $this->key);
    }
}
