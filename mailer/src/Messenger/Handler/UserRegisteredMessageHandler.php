<?php

namespace App\Messenger\Handler;

use App\Messenger\Message\UserSuccessfullyStoredMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserRegisteredMessageHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    public function __invoke(UserSuccessfullyStoredMessage $message): void
    {

        $this->logger->info(\sprintf('[HANDLER] Name: %s. Email: %s. Code: %s', $message->getName(), $message->getEmail(), $message->getCode()));
    }

}
