<?php

namespace App\Cryptography\Services;


class Signer
{
    public function __construct(private string $signatureSecret)
    {
    }

    private function recursiveKeySort(array $data): array
    {
        $result = [];

        $keys = array_keys($data);
        sort($keys);
        foreach ($keys as $key) {
            $value = $data[$key];
            if (is_array($value)) {
                $value = $this->recursiveKeySort($value);
            }
            $result[$key] = $value;
        }

        return $result;
    }

    public function sign(array $data): string
    {
        $toBeSigned = $this->recursiveKeySort($data);

        return hash_hmac(
            'sha256',
            json_encode($toBeSigned, JSON_UNESCAPED_SLASHES),
            $this->signatureSecret
        );
    }

    public function verify(string $signature, array $data): bool
    {
        return $signature === $this->sign($data);
    }
}
