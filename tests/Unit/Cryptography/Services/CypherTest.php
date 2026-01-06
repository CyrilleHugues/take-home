<?php

namespace App\Tests\Unit\Cryptography\Services;

use App\Cryptography\Services\Cypher;
use PHPUnit\Framework\TestCase;


class CypherTest extends TestCase
{
    public function testItWillReturnEncryptedSimpleData(): void
    {
        $data = ['test' => 'thing to encrypt'];
        $cypher = new Cypher();

        $this->assertEquals(['test' => 'dGhpbmcgdG8gZW5jcnlwdA=='], $cypher->encrypt($data));
    }

    public function testItWillReturnEncryptedMixedData(): void
    {
        $data = ['first' => 'thing to encrypt', 'second' => 'another thing', 'third' => ['sub' => 'array']];
        $cypher = new Cypher();

        $this->assertEquals(
            [
                'first' => 'dGhpbmcgdG8gZW5jcnlwdA==',
                'second' => 'YW5vdGhlciB0aGluZw==',
                'third' => 'eyJzdWIiOiJhcnJheSJ9',
            ],
            $cypher->encrypt($data)
        );
    }

    public function testItWillDecryptAFullyEncryptedPayload(): void
    {
        $data = ['test' => 'dGhpbmcgdG8gZW5jcnlwdA=='];
        $cypher = new Cypher();

        $this->assertEquals(
            ['test' => 'thing to encrypt'],
            $cypher->decrypt($data),
        );
    }

    public function testItWillDecryptAPartiallyEncryptedPayload(): void
    {
        $data = ['first' => 'dGhpbmcgdG8gZW5jcnlwdA==', 'second' => "john@example.com"];
        $cypher = new Cypher();

        $this->assertEquals(
            ['first' => 'thing to encrypt', 'second' => "john@example.com"],
            $cypher->decrypt($data),
        );
    }
}
