<?php

namespace App\Controller;

use App\Service\FindUserByEmailActionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FinUserByEmailAction
{

  public function __construct(private FindUserByEmailActionService $findUserByEmailActionService)
  {
  }

  /**
   * @Route("/api/internal/users", methods={"GET"}, name="api_internal_get_users")
   */
  public function __invoke(Request $request): JsonResponse
  {

    if (null === $email = $request->query->get('email')) {
      throw new BadRequestHttpException('Email parameter is mandatory');
    }

    if (null === $user = $this->findUserByEmailActionService->__invoke($email)) {
      throw new NotFoundHttpException(\sprintf('User with email %s not found', $email));
    }

    return new JsonResponse($user->toArray());
  }
}
