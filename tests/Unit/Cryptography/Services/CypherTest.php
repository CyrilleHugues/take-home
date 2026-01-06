<?php

namespace App\Tests\Unit\Cryptography\Services;

use App\Cryptography\Services\Base64Strategy;
use App\Cryptography\Services\Cypher;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;


class CypherTest extends TestCase
{
    private Cypher $cypher;

    public function setUp(): void
    {
        parent::setUp();
        $this->cypher = new Cypher(new Base64Strategy());
    }

    public static function encryptionProvider(): array
    {
        return [
            'simple case' => [
                ['test' => 'thing to encrypt /'],
                ['test' => 'dGhpbmcgdG8gZW5jcnlwdCAv'],
            ],
            'handling sub objects' => [
                ['first' => 'thing to encrypt', 'second' => 'another thing', 'third' => ['sub' => 'array']],
                ['first' => 'dGhpbmcgdG8gZW5jcnlwdA==', 'second' => 'YW5vdGhlciB0aGluZw==', 'third' => 'eyJzdWIiOiJhcnJheSJ9']
            ],
            'example' => [
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'contact' => [
                        "email" => "john@example.com",
                        "phone" => "123-456-7890"
                    ],
                ],
                [
                    'name' => 'Sm9obiBEb2U=',
                    'age' => 'MzA=',
                    'contact' => 'eyJlbWFpbCI6ImpvaG5AZXhhbXBsZS5jb20iLCJwaG9uZSI6IjEyMy00NTYtNzg5MCJ9',
                ],
            ]
        ];
    }

    #[DataProvider('encryptionProvider')]
    public function testEncryption(array $input, array $expected): void
    {
        $this->assertEquals($expected, $this->cypher->encrypt($input));
    }

    public static function decryptionProvider(): array
    {
        return [
            'simple case' => [
                ['test' => 'dGhpbmcgdG8gZW5jcnlwdCAv'],
                ['test' => 'thing to encrypt /'],
            ],
            'handling sub objects' => [
                ['first' => 'dGhpbmcgdG8gZW5jcnlwdA==', 'second' => 'YW5vdGhlciB0aGluZw==', 'third' => 'eyJzdWIiOiJhcnJheSJ9'],
                ['first' => 'thing to encrypt', 'second' => 'another thing', 'third' => ['sub' => 'array']],
            ],
            'partially encrypted' => [
                ['first' => 'dGhpbmcgdG8gZW5jcnlwdA==', 'second' => "john@example.com"],
                ['first' => 'thing to encrypt', 'second' => "john@example.com"],
            ],
            'example1' => [
                [
                    'name' => 'Sm9obiBEb2U=',
                    'age' => 'MzA=',
                    'contact' => 'eyJlbWFpbCI6ImpvaG5AZXhhbXBsZS5jb20iLCJwaG9uZSI6IjEyMy00NTYtNzg5MCJ9',
                ],
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'contact' => [
                        "email" => "john@example.com",
                        "phone" => "123-456-7890"
                    ],
                ],
            ],
            'example2' => [
                [
                    'name' => 'Sm9obiBEb2U=',
                    'age' => 'MzA=',
                    'contact' => 'eyJlbWFpbCI6ImpvaG5AZXhhbXBsZS5jb20iLCJwaG9uZSI6IjEyMy00NTYtNzg5MCJ9',
                    "birth_date" => "1998-11-19",
                ],
                [
                    'name' => 'John Doe',
                    'age' => 30,
                    'contact' => [
                        "email" => "john@example.com",
                        "phone" => "123-456-7890"
                    ],
                    "birth_date" => "1998-11-19",
                ],
            ],
        ];
    }

    #[DataProvider('decryptionProvider')]
    public function testDecryption(array $input, array $expected): void
    {
        $this->assertEquals($expected, $this->cypher->decrypt($input));
    }
}
