<?php

namespace App\Messenger\Handler;

use App\Entity\User;
use App\Messenger\Message\UserRegisteredMessage;
use App\Messenger\Message\UserSuccessfullyStoredMessage;
use App\Messenger\RoutingKey;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UserRegisteredMessageHandler implements MessageHandlerInterface
{

    private UserRepository $userRepository;
    private MessageBusInterface $bus;

    public function __construct(UserRepository $userRepository, MessageBusInterface $bus)
    {
        $this->userRepository = $userRepository;
        $this->bus = $bus;
    }

    public function __invoke(UserRegisteredMessage $message): void
    {
        $user = new User($message->getName(), $message->getEmail(), \sha1(\uniqid()));

        # esto es una opción para comprobar si un usuario ya existe
        try {
            $this->userRepository->save($user);
    $this->bus->dispatch(
        new UserSuccessfullyStoredMessage($user->getName(), $user->getEmail(), $user->getCode()),
        [new AmqpStamp(RoutingKey::APPLICATION_MAILER_QUEUE)]
    );

        } catch (\Exception $e) {
            # lo que hace esta excepción es evitar que se procese de nuevo
            # osea si intentamos persistir un usuario que ya existe
            # simplemente vamos a descartar el mensaje y no lo vamos a reintentar
            throw new UnrecoverableMessageHandlingException(\sprintf('User with email %s is already exist', $message->getEmail()));
        }

    }

}
