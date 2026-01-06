<?php

namespace App\Tests\Integration\Cryptography\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DecryptionControllerTest extends WebTestCase
{
    public function testDecryptionEndpoint(): void
    {
        $client = static::createClient();
        $payload = '{"name":"Sm9obiBEb2U=","age":"MzA=","contact":"eyJlbWFpbCI6ImpvaG5AZXhhbXBsZS5jb20iLCJwaG9uZSI6IjEyMy00NTYtNzg5MCJ9"}';
        $client->request('POST', '/decrypt', content: $payload);

        $this->assertEquals(
            '{"name":"John Doe","age":30,"contact":{"email":"john@example.com","phone":"123-456-7890"}}',
            $client->getResponse()->getContent()
        );
    }
}
