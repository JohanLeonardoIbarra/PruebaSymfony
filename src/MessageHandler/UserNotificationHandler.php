<?php

namespace App\MessageHandler;

use App\Message\UserNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UserNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(UserNotification $message)
    {
        $email = $message->getEmail();
        $text = $message->getMessage();
    }
}
