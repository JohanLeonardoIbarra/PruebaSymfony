<?php

namespace App\Message;

final class UserNotification
{

     private string $email;
     private string $message;

     public function __construct(string $email, string $message)
     {
         $this->email = $email;
         $this->message = $message;
     }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
