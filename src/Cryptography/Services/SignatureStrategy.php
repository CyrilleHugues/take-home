<?php

namespace App\Cryptography\Services;


interface SignatureStrategy
{
    public function sign(array $data): string;
}
