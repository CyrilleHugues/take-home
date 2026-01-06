<?php

namespace App\Tests\Integration\Cryptography\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VerifyDataSignatureControllerTest extends WebTestCase
{
    public function testVerifyEndpointReturn400IfSignatureDoNotMatch(): void
    {
        $client = static::createClient();
        $payload = '{"data":{"name":"John Doe","age":30,"contact":{"email":"john@example.com","phone":"123-456-7890"}}, "signature": "f6ac1891f01c9e3e1ffc7b61cfe6341c11f6ef835e4da3bd0a71593f9b53d0de"}';
        $client->request('POST', '/verify', content: $payload);

        $this->assertEquals(
            Response::HTTP_BAD_REQUEST,
            $client->getResponse()->getStatusCode()
        );
    }

    public function testVerifyEndpointReturn204WhenMatch(): void
    {
        $client = static::createClient();
        $payload = '{"data":{"name":"John Doe","age":30,"contact":{"email":"john@example.com","phone":"123-456-7890"}}, "signature": "7362939889fc3f289e24268f3afc46fc6c4684d61bba03523b7b774d0ed1221b"}';
        $client->request('POST', '/verify', content: $payload);

        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $client->getResponse()->getStatusCode()
        );
    }
}
