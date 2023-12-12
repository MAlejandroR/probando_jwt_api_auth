<?php


require "vendor/autoload.php";

use Database\DB;
use Database\JWTHandler;

use Dotenv\Dotenv;
use Firebase\JWT;

$dotenv = Dotenv::createImmutable(__DIR__ . "/docker");
$dotenv->load();


$hora = date("H:i:s");
error_log("Acceso nuevo  $hora  \n", 3, "log.txt");
error_log("==============================\n", 3, "log.txt");


//if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
//    // La solicitud OPTIONS no necesita más procesamiento
//    $hora = date("H:i:s");
//    error_log("Solicitud Option $hora !!!! \n", 3, "log.txt");
//    header("Access-Control-Allow-Origin: http://localhost:3000");
//    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//    header("Access-Control-Allow-Headers: Content-Type");
//    header("Access-Control-Allow-Credentials: true");
//    exit(); // Salir temprano para las solicitudes OPTIONS
//}

$method = $_SERVER['REQUEST_METHOD'];
$db = new DB();
switch ($method) {
    case "GET":
        $id = $_GET['id'] ?? null;
        if (is_null($id)) {
            $datos = $db->get_usuarios();
            http_response_code(200);
            echo json_encode($datos);
            exit;
        } else {
            $user = $db->get_usuario($id);
            if (is_null($user)) {
                http_response_code(400);
                $msj = [
                    'status' => 'success',
                    'message' => "Usuario $id no existe",
                ];
                echo json_encode($msj);
                exit;
            }
            $usuario = \Database\Authenticar::validar_autenticacion();
            if ($usuario ==null){ //No hay token, usuario no registrado
                http_response_code(403);
                $msj = [
                    'status' => 'Forbbiden',
                ];
                echo json_encode($msj);
                exit;
            }
            var_dump($usuario);
            if ($usuario instanceof Exception) { //seguramente token expirado
                http_response_code(401);
                $msj = [
                    'status' => 'Unauthorized',
                ];
                echo json_encode($msj);
                exit;
            }
                http_response_code(200);
                echo json_encode($usuario);
                exit;

        }



        break;
    case "POST":
        $user = $_POST['usuario'];
        $pass = $_POST['password'];
        $datos = is_null($user) ? $db->get_usuarios() : $db->get_usuario($user);
        echo json_encode($datos);
        break;

}

$hora = date("H:i:s");
error_log("Fin consulta\n", 3, "log.txt");
error_log("_______________________________________\n", 3, "log.txt");

