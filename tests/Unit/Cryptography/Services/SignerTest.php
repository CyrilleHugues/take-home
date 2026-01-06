<?php

namespace App\Tests\Unit\Cryptography\Services;

use App\Cryptography\Services\SignatureHmacStrategy;
use App\Cryptography\Services\Signer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SignerTest extends TestCase
{
    private Signer $signer;

    public function setUp(): void
    {
        parent::setUp();
        $this->signer = new Signer(new SignatureHmacStrategy('lkbmzH70ZglvHRhfIFht'));
    }

    public static function signProvider(): array
    {
        return [
            'simple test' => [
                ['a' => 'b', 'c' => 'd'],
                '7d597e6a250585faaf3621cfd2c6bdc0b5e122649851d1d2170fbbbe4351e2d6'
            ],
            'check different order do not impact signature' => [
                ['a' => 'b', 'c' => 'd'],
                '7d597e6a250585faaf3621cfd2c6bdc0b5e122649851d1d2170fbbbe4351e2d6'
            ],
            'check complex example' => [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'contact' => [
                        "email" => "john@example.com",
                        "phone" => "123-456-7890"
                    ],
                ],
                '7362939889fc3f289e24268f3afc46fc6c4684d61bba03523b7b774d0ed1221b',
            ],
            'check complex example (different order)' => [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'contact' => [
                        "phone" => "123-456-7890",
                        "email" => "john@example.com"
                    ],
                ],
                '7362939889fc3f289e24268f3afc46fc6c4684d61bba03523b7b774d0ed1221b',
            ],
        ];
    }

    #[DataProvider('signProvider')]
    public function testSignMethod($input, $expected): void
    {
        $this->assertEquals($expected, $this->signer->sign($input));
    }

    public static function verifyProvider(): array
    {
        return [
            'match' => [
                ['a' => 'b', 'c' => 'd'],
                '7d597e6a250585faaf3621cfd2c6bdc0b5e122649851d1d2170fbbbe4351e2d6',
                true
            ],
            'no match' => [
                ['a' => 'b', 'c' => 'd'],
                '7362939889fc3f289e24268f3afc46fc6c4684d61bba03523b7b774d0ed1221b',
                false
            ]
        ];
    }

    #[DataProvider('verifyProvider')]
    public function testVerifyMethod($data, $signature, $expected): void
    {
        $this->assertEquals($expected, $this->signer->verify($signature, $data));
    }
}
