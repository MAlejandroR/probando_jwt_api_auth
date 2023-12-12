<?php

namespace Database;

class Authenticar
{

    public static function autenticar($usuario, $password, DB $db):array|bool
    {
        $user = $db->validar_usuario($usuario, $password);
        if (($user===false)||is_null($user)) {
            return false;
        } else {

            $data = [
                "id"=> $user->id,
                "username" => $user->nombre,
                "role" => $user->rol,  // o cualquier otro rol
            ];
            $token = JWTHandler::generarToken($data);

            $msj = [
                "status" => "success",
                "message" => "Autenticación exitosa",
                "token"=>$token
                ];
            return $msj;
        }
    }
    public static function validar_autenticacion(){
        $token = $_SERVER["HTTP_AUTHORIZATION"] ?? $_COOKIE['token']??null;
        //Si no hay token retorno para un forbbiden
        if ($token==null)
            return null;
        $key = $_ENV['KEY'];
        error_log("token en sitio.php: -$token-\n",3,"log.txt");
        try {
            JWTHandler::set_key($key);
            $decoded = JWTHandler::verificarToken($token);
            return $decoded;
        } catch (Exception $e) {
// Token inválido
            return $e;
        }



    }

}