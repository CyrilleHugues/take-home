<?php

namespace App\Cryptography\Services;

class Cypher
{
    public function __construct(private EncryptionStrategy $encryptionStrategy)
    {
    }

    public function encrypt(array $data): array
    {
        $encrypted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_SLASHES);
            }
            $encrypted[$key] = $this->encryptionStrategy->encrypt($value);
        }

        return $encrypted;
    }

    private function decryptValue(string $value)
    {
        try {
            $decoded = $this->encryptionStrategy->decrypt($value);
        } catch (ValueIsUnencrypted) {
            return $value;
        }

        $parsed = json_decode($decoded, true);
        if ($parsed === null) {
            return $decoded;
        }

        return $parsed;
    }

    public function decrypt(array $data): array
    {
        $decrypted = [];
        foreach ($data as $key => $value) {
            $decrypted[$key] = $this->decryptValue($value);
        }

        return $decrypted;
    }
}
