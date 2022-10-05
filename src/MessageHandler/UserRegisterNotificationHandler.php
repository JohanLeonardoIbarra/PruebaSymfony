<?php

namespace App\MessageHandler;
use App\Message\UserRegisterNotification;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Service\Attribute\Required;

final class UserRegisterNotificationHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    #[Required]
    public function setMailer(MailerInterface $mailer): void
    {
        $this->mailer = $mailer;
    }

    public function __invoke(UserRegisterNotification $message)
    {
        $userEmail = $message->getEmail();
        $email = (new Email())
            ->from('johanleonardois@ufps.edu.co',)
            ->to($userEmail)
            ->subject('User Registry')
            ->html('<h1>Te has registrado con exito en la plataforma SymfonyPrueba!!!<h1>');
        $this->mailer->send($email);
    }
}
