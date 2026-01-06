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

    public function decrypt(array $data): array
    {
        return $data;
    }
}
