<?php

namespace Database;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


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
            self::set_key($_ENV['KEY']);

            $token = JWT::encode($data, self::$key, "HS256");
            $decoded = self::verificarToken($token);

            error_log("Generado el token: $token\n", 3, "log.txt");
            $decoded = print_r($decoded, 1);
            error_log("Recien decodificado : $decoded\n", 3, "log.txt");
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
            error_log("en verificar token : -$token-\n", 3, "log.txt");
            error_log("en verificar key :-" . self::$key . "- \n", 3, "log.txt");

            $decoded = JWT::decode($token, new Key(self::$key, 'HS256'));
            error_log("en verificar toekn después:\n", 3, "log.txt");
            return $decoded;

        } catch (Exception $e) {

            error_log("en verificar token sin exito  :" . $e->getMessage() . " \n", 3, "log.txt");
            return null;

        } catch (ExpiredException $e) {
            // Token ha caducado
            error_log("Token caducado: " . $e->getMessage() . " \n", 3, "log.txt");
            return null;
        }
    }
}