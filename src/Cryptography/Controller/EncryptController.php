<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Cypher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EncryptController
{
    public function __construct(private Cypher $cypher)
    {
    }

    #[Route('/encrypt', name: 'cryptography_encrypt', methods: ['POST'])]
    public function encrypt(Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $encryptedData = $this->cypher->encrypt($payload);
        return new JsonResponse($encryptedData, JsonResponse::HTTP_OK);
    }
}
