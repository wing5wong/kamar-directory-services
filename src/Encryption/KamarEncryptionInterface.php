<?php

namespace Wing5wong\KamarDirectoryServices\Encryption;

interface KamarEncryptionInterface
{
    public function encrypt(string $string): string|false;
    public function decrypt(string $string): string|false;
}
