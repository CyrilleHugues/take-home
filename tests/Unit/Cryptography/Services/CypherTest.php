<?php

namespace App\Tests\Unit\Cryptography\Services;

use App\Cryptography\Services\Base64Strategy;
use App\Cryptography\Services\Cypher;
use PHPUnit\Framework\TestCase;


class CypherTest extends TestCase
{
    private Cypher $cypher;

    public function setUp(): void
    {
        parent::setUp();
        $this->cypher = new Cypher(new Base64Strategy());
    }

    public function testItWillReturnEncryptedSimpleData(): void
    {
        $data = ['test' => 'thing to encrypt'];

        $this->assertEquals(['test' => 'dGhpbmcgdG8gZW5jcnlwdA=='], $this->cypher->encrypt($data));
    }

    public function testItWillReturnEncryptedMixedData(): void
    {
        $data = ['first' => 'thing to encrypt', 'second' => 'another thing', 'third' => ['sub' => 'array']];

        $this->assertEquals(
            [
                'first' => 'dGhpbmcgdG8gZW5jcnlwdA==',
                'second' => 'YW5vdGhlciB0aGluZw==',
                'third' => 'eyJzdWIiOiJhcnJheSJ9',
            ],
            $this->cypher->encrypt($data)
        );
    }

    public function testItWillDecryptAFullyEncryptedPayload(): void
    {
        $data = ['test' => 'dGhpbmcgdG8gZW5jcnlwdA=='];

        $this->assertEquals(
            ['test' => 'thing to encrypt'],
            $this->cypher->decrypt($data),
        );
    }

    public function testItWillDecryptAPartiallyEncryptedPayload(): void
    {
        $data = ['first' => 'dGhpbmcgdG8gZW5jcnlwdA==', 'second' => "john@example.com"];

        $this->assertEquals(
            ['first' => 'thing to encrypt', 'second' => "john@example.com"],
            $this->cypher->decrypt($data),
        );
    }

    public function testItWillDecryptObjectsToo(): void
    {
        $data = [
            'first' => 'dGhpbmcgdG8gZW5jcnlwdA==',
            'second' => 'YW5vdGhlciB0aGluZw==',
            'third' => 'eyJzdWIiOiJhcnJheSJ9',
        ];

        $this->assertEquals(
            ['first' => 'thing to encrypt', 'second' => 'another thing', 'third' => ['sub' => 'array']],
            $this->cypher->decrypt($data)
        );
    }
}
