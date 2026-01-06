<?php

namespace App\Cryptography\Services;

class Cypher
{
    public function encrypt(array $data): array
    {
        $encrypted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_SLASHES);
            }
            $encrypted[$key] = base64_encode($value);
        }

        return $encrypted;
    }

    private function decryptValue(string $value)
    {
        $decoded = base64_decode($value, true);

        if ($decoded === false) {
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
