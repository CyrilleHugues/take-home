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
}
