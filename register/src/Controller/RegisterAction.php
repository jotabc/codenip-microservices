<?php

namespace App\Controller;

use App\Http\DTO\RegisterRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterAction extends AbstractController
{
    /**
     * @Route("/api/register", name="api_register", methods={"POST"})
     */
    public function __invoke(RegisterRequest $registerRequest): JsonResponse
    {
        return  new JsonResponse();
    }

}
