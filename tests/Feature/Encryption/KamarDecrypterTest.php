<?php

namespace Wing5wong\Tests\Feature\Encryption;

use Wing5wong\KamarDirectoryServices\Encryption\KamarEncryptionInterface as Decrypter;
use Wing5wong\KamarDirectoryServices\Tests\TestCase;

class KamarDecrypterTest extends TestCase
{
    private $testString = "My Encrypted Test String";
    private $testEncryptedString = "J8h5u6d6OAVxJ53d5LY7QiD5A46b+P1RaSeURavVA+Q=";

    public function test_it_can_encrypt()
    {
        $this->assertEquals($this->testEncryptedString, app()->make(Decrypter::class)->encrypt($this->testString));
    }

    public function test_it_can_decrypt()
    {
        $this->assertEquals($this->testString, app()->make(Decrypter::class)->decrypt($this->testEncryptedString));
    }
}
