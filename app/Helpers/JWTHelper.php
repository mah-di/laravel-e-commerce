<?php

namespace App\Helpers;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{

    public static function createToekn(string $id, string $email)
    {
        $key = env('JWT_SECRET_KEY');

        $payload = [
            'iss' => 'OSTAD_POS',
            'iat' => time(),
            'exp' => time()+60*60*24*30,
            'id' => $id,
            'email' => $email
        ];

        return JWT::encode($payload, $key, "HS256");
    }

    public static function verifyToekn(?string $token)
    {
        try {
            if ($token === null) throw new Exception("unauthorized", 401);

            $key = env('JWT_SECRET_KEY');

            return JWT::decode($token, new Key($key, "HS256"));

        } catch (Exception $exception) {
            return null;
        }
    }

}
