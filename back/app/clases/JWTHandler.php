<?php

namespace Database;
use Firebase\JWT\JWT;

require __DIR__ . "/../vendor/autoload.php";

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
        try {
            $token = JWT::encode($data, self::$key, "HS256");
            error_log("Generado el token: $token\n", 3, "log.txt");
            return $token;
        } catch (Exception $e) {
            error_log("Error al generar el token: " . $e->getMessage() . "\n", 3, "log.txt");
            return null; // O manejar el error de alguna manera
        }

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