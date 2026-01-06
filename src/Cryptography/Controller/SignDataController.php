<?php

namespace App\Cryptography\Controller;

use App\Cryptography\Services\Signer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SignDataController
{
    #[Route('/sign', 'cryptography_sign', methods: ['POST'])]
    public function sign(Signer $signer, Request $request): JsonResponse
    {
        $payload = $request->getPayload()->all();
        
        return new JsonResponse(['signature' => $signer->sign($payload)]);
    }
}
