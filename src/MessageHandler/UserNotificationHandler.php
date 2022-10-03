<?php

namespace App\MessageHandler;

use App\Message\UserNotification;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UserNotificationHandler implements MessageHandlerInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(UserNotification $message)
    {
        $email = $message->getEmail();
        $text = $message->getMessage();
        $this->logger->info($email.' '.$text);
    }
}
