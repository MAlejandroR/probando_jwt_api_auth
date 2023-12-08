<?php

namespace Database;
use Firebase\JWT\JWT;

require __DIR__."/../vendor/autoload.php";

class JWTHandler
{
    private static $key; // Cambia esto a una clave segura

    public static function set_key($key)
    {
        self::$key = $key;
    }


    public
    static function generarToken($data)
    {
        $token = JWT::encode($data, self::$key,"HS256");
        return $token;
    }

    public
    static function verificarToken($token)
    {
        try {
            $decoded = JWT::decode($token, self::$key, array('HS256'));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}