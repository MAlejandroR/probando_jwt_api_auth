<?php


require "vendor/autoload.php";

use Database\DB;
use Database\JWTHandler;

use Dotenv\Dotenv;
use Firebase\JWT;

$dotenv= Dotenv::createImmutable(__DIR__."/docker");
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
switch ($method){
    case "GET":
        $id = $_GET['id']??null;
        $datos = is_null($id)?$db->get_usuarios():$db->get_usuario($id) ;
        echo json_encode($datos);
        break;
    case "POST":
        $user = $_POST['usuario'];
        $pass = $_POST['password'];
        $datos = is_null($user)?$db->get_usuarios():$db->get_usuario($user) ;
        echo json_encode($datos);
        break;
}

$hora = date("H:i:s");
error_log("Fin consulta\n", 3, "log.txt");
error_log("_______________________________________\n", 3, "log.txt");

