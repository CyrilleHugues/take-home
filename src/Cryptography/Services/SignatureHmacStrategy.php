<?php

namespace App\Cryptography\Services;


class SignatureHmacStrategy implements SignatureStrategy
{
    public function __construct(private string $signatureSecret)
    {
    }

    public function sign(array $data): string
    {
        return hash_hmac(
            'sha256',
            json_encode($data, JSON_UNESCAPED_SLASHES),
            $this->signatureSecret
        );
    }
}
