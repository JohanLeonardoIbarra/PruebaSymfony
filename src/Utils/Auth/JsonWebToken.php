<?php

namespace App\Utils\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JsonWebToken implements AuthenticationInterface
{
    private const key = "Hola";
    private const format = "HS256";

    public static function encrypt(Array $payload): string
    {
        return JWT::encode($payload, self::key, self::format);
    }

    public static function decrypt(string $token): \stdClass
    {
        return JWT::decode($token, new Key(self::key, self::format));
    }

    public static function verify(string $token): bool
    {
        if (self::decrypt($token)['user']) {
            return true;
        }

        return false;
    }
}