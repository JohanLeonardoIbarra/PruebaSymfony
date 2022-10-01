<?php

namespace App\Utils\Auth;

interface AuthenticationInterface
{
    public static function encrypt(Array $payload): string;

    public static function verify(string $token): bool;
}