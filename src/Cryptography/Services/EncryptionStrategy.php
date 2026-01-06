<?php

namespace App\Cryptography\Services;

use App\Cryptography\Services\ValueIsUnencrypted;


interface EncryptionStrategy
{
    public function encrypt(string $data): string;
    /**
     * @throws ValueIsUnencrypted
     */
    public function decrypt(string $data): string;
}
