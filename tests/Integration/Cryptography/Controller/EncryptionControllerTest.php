<?php

namespace App\Tests\Integration\Cryptography\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class EncryptionControllerTest extends WebTestCase
{
    public function testEncryptionEndpoint(): void
    {
        $client = static::createClient();
        $payload = '{"name":"John Doe","age":30,"contact":{"email":"john@example.com","phone":"123-456-7890"}}';
        $client->request('POST', '/encrypt', content: $payload);

        $this->assertEquals(
            '{"name":"Sm9obiBEb2U=","age":"MzA=","contact":"eyJlbWFpbCI6ImpvaG5AZXhhbXBsZS5jb20iLCJwaG9uZSI6IjEyMy00NTYtNzg5MCJ9"}',
            $client->getResponse()->getContent()
        );
    }
}
