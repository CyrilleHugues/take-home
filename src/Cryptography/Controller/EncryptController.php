<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Cypher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class EncryptController
{
    #[Route('/encrypt', name: 'cryptography_encrypt', methods: ['POST'])]
    public function encrypt(Cypher $cypher, Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        $encryptedData = $cypher->encrypt($payload);

        return new JsonResponse($encryptedData);
    }
}
