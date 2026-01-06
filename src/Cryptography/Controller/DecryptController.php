<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Cypher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DecryptController
{
    #[Route('/decrypt', name: 'cryptography_decrypt', methods: ['POST'])]
    public function decrypt(Cypher $cypher, Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $decryptedData = $cypher->decrypt($payload);

        return new JsonResponse($decryptedData);
    }
}
