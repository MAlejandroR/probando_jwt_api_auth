<?php


require "vendor/autoload.php";

use Database\DB;
use Database\JWTHandler;

use Dotenv\Dotenv;
use Firebase\JWT;
$hora = date("H:i:s");
error_log("Accediendo  $hora !!!! \n", 3, "log.txt");


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


//Para tracear datos
$datos = print_r($_POST, 1);
$hora = date("H:i:s");
error_log("Acceso $hora \n", 3, "log.txt");
error_log("Datos: -$datos-", 3, "log.txt");
error_log("\n", 3, "log.txt");




//ini_set("display_errors", true);
//error_reporting(E_ALL);

$dotenv = Dotenv::createImmutable(__DIR__."/docker/");
$dotenv->load();


$db = new DB();

//Porblema 1, no lee los datos de post
$usuario = htmlspecialchars(filter_input(INPUT_POST, 'usuario'));
$password = filter_input(INPUT_POST, 'password');

$key = $_ENV['KEY'];
JWTHandler::set_key($key);
error_log("Antes de valida usuario \n", 3, "log.txt");
$rol =$db->validar_usuario($usuario, $password);
if ($rol!==false ) {
    error_log("Habiendo validado usuario\n", 3, "log.txt");
    // Autenticación exitosa, genera un JWT

    //Problema 2 . Tema de CORS para dar acceso, pero no funciona
//    header("Access-Control-Allow-Origin: *");
//    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//    header("Access-Control-Allow-Headers: Content-Type");
//    header("Access-Control-Allow-Credentials: true");
//    header('Content-Type: application/json');
    error_log("Se han puesto los header \n", 3, "log.txt");
    $data = ["usuario" => $usuario,
        "rol"=>$rol,
        "exp"=>time() + 3600
    ];

    $token = JWTHandler::generarToken($data);
    error_log("Generado tocke $token \n", 3, "log.txt");
    // Retorna el token como respuesta
    echo json_encode(array('token' => $token));
} else {
    error_log("Autentication fallida \n", 3, "log.txt");
//    header('Content-Type: application/json');
    // Autenticación fallida
  //  header('HTTP/1.0 401 Unauthorized');
    echo json_encode(array('error' => 'Autenticación fallida'));
}


?>
