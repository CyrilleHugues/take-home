<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Cypher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class DecryptController
{
    public function __construct(private Cypher $cypher)
    {
    }

    #[Route('/decrypt', name: 'cryptography_decrypt', methods: ['POST'])]
    public function decrypt(Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $decryptedData = $this->cypher->decrypt($payload);

        return new JsonResponse($decryptedData, JsonResponse::HTTP_OK);
    }
}
