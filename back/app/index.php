<?php


require "vendor/autoload.php";

use Database\DB;
use Database\JWTHandler;
use Database\Authenticar;


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
            if ($usuario == null) { //No hay token, usuario no registrado
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
            var_dump($usuario);
            echo json_encode($usuario);
            exit;

        }
        break;
    case "DELETE": //solo admin puede
        $autorizacion = Authenticar::validar_usuario_rol("admin");
        if (!$autorizacion) {
            http_response_code(403);
            $msj = [
                'status' => 'Forbbiden',
            ];
            echo json_encode($msj);
            exit;
        }
        $id = $_GET['id'];
        $rtdo = $db->delete_usuario($id);
        if ($rtdo){
            http_response_code(204);
            $msj = [
                'status' => "Usuario $id eliminado ",
            ];
            echo json_encode($msj);
            exit;
        }else{
            http_response_code(500);
            $msj = [
                'status' => "No se ha podido actualziar el usuario $id" ,
            ];
            echo json_encode($msj);
            exit;

        }

    case "POST": //solo admin puede
        $autorizacion = Authenticar::validar_usuario_rol("admin");
        if (!$autorizacion) {
            http_response_code(403);
            $msj = [
                'status' => 'Forbbiden',
            ];
            echo json_encode($msj);
            exit;
        }
        $user = $_POST['usuario'];
        $pass = $_POST['password'];
        $role = $_POST['role'];
        $rtdo = $db->insertar_usuario($user, $pass, $role);
        if ($rtdo){
            http_response_code(201);
            $msj = [
                'status' => 'Usuario $user insertado ',
            ];
            echo json_encode($msj);
            exit;
        }
    case "PUT":// Es un update solo admin o gestor
        $autorizacion1 = Authenticar::validar_usuario_rol("admin");
        $autorizacion2 = Authenticar::validar_usuario_rol("gestor");
        if (!$autorizacion1 && !$autorizacion2) {
            http_response_code(403);
            $msj = [
                'status' => 'Forbbiden',
            ];
            echo json_encode($msj);
            exit;
        }


// Obtener los datos del cuerpo de la solicitud
        $datos = json_decode(file_get_contents("php://input"), true);


        $user = $datos['usuario'];
        $pass = $datos['password'];
        $role = $datos['role'];
        $id = $_GET['id'];
        $rtdo = $db->update_usuario($id, $user, $pass, $role);
        if ($rtdo){
            http_response_code(200);
            $msj = [
                'status' => "Usuario $user actualizado ",
            ];
            echo json_encode($msj);
            exit;
        }else{
            http_response_code(500);
            $msj = [
                'status' => "No se ha podido actualziar el usuario $id" ,
            ];
            echo json_encode($msj);
            exit;
            
        }
        break;
    case "POST":
        $autorizacion = Authenticar::validar_usuario_rol("admin");
        if (!$autorizacion) {
            http_response_code(403);
            $msj = [
                'status' => 'Forbbiden',
            ];
            echo json_encode($msj);
            exit;
        }
        $user = $_POST['usuario'];
        $pass = $_POST['password'];
        $role = $_POST['role'];
        $rtdo = $db->insertar_usuario($user, $pass, $role);
        if ($rtdo){
            http_response_code(201);
            $msj = [
                'status' => 'Usuario $user insertado ',
            ];
            echo json_encode($msj);
            exit;
        }
}

$hora = date("H:i:s");
error_log("Fin consulta\n", 3, "log.txt");
error_log("_______________________________________\n", 3, "log.txt");

