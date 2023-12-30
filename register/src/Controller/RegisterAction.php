<?php

namespace App\Controller;

use App\Http\DTO\RegisterRequest;
use App\Services\RegisterActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RegisterAction extends AbstractController
{
    private RegisterActionService $registerActionService;

    public function __construct(RegisterActionService $registerActionService)
    {
        $this->registerActionService = $registerActionService;
    }

    /**
     * @Route("/api/register", name="api_register", methods={"POST"})
     */
    public function __invoke(RegisterRequest $registerRequest): JsonResponse
    {
        $this->registerActionService->__invoke($registerRequest->getName(), $registerRequest->getEmail());
        return new JsonResponse();
    }

}
