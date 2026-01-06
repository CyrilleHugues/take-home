<?php

namespace App\Tests\Integration\Cryptography\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class SignDataControllerTest extends WebTestCase
{
    public function testSignEndpoint(): void
    {
        $client = static::createClient();
        $payload = '{"name":"John Doe","age":30,"contact":{"email":"john@example.com","phone":"123-456-7890"}}';
        $client->request('POST', '/sign', content: $payload);

        $this->assertEquals(
            '{"signature":"7362939889fc3f289e24268f3afc46fc6c4684d61bba03523b7b774d0ed1221b"}',
            $client->getResponse()->getContent()
        );
    }
}
