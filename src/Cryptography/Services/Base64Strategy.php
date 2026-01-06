<?php

namespace App\Cryptography\Services;


class Base64Strategy implements EncryptionStrategy
{
    public function encrypt(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * @throws ValueIsUnencrypted
     */
    public function decrypt(string $data): string
    {
        $decrypted = base64_decode($data, true);
        if ($decrypted === false) {
            throw new ValueIsUnencrypted();
        }

        return $decrypted;
    }
}
