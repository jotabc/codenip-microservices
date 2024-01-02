<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class FindUserByEmailActionService
{

  public function __construct(private UserRepository $userRepository)
  {
  }

  public function __invoke(string $email): ?User
  {
    return $this->userRepository->findOneBy(['email' => $email]);
  }
}
