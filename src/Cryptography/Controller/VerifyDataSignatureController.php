<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Signer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class VerifyDataSignatureController
{
    #[Route('/verify', 'cryptography_verify', methods: ['POST'])]
    public function verify(Signer $signer, Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        
        if ($signer->verify($payload['signature'], $payload['data'])) {
            return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, JsonResponse::HTTP_BAD_REQUEST);
    }
}
