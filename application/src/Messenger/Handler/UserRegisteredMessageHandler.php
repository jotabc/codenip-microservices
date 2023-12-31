<?php

namespace App\Messenger\Handler;

use App\Entity\User;
use App\Messenger\Message\UserRegisteredMessage;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserRegisteredMessageHandler implements MessageHandlerInterface
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(UserRegisteredMessage $message): void
    {
        $user = new User($message->getName(), $message->getEmail());

        # esto es una opción para comprobar si un usuario ya existe
        try {
            $this->userRepository->save($user);
        } catch (\Exception $e) {
            # lo que hace esta excepción es evitar que se procese de nuevo
            # osea si intentamos persistir un usuario que ya existe
            # simplemente vamos a descartar el mensaje y no lo vamos a reintentar
            throw new UnrecoverableMessageHandlingException(\sprintf('User with email %s is already exist', $message->getEmail()));
        }

    }

}
