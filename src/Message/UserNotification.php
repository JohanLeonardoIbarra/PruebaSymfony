<?php

namespace App\Message;

final class UserNotification
{

     private string $email;
     private string $message;
     private array $context;

     public function __construct(string $email, string $message, array $context = [])
     {
         $this->email = $email;
         $this->message = $message;
         $this->context = $context;
     }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
