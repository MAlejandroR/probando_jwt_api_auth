<?php

require "vendor/autoload.php";

use Database\DB;

use Database\Authenticar;

use Dotenv\Dotenv;


$dotenv= Dotenv::createImmutable(__DIR__."/docker");
$dotenv->load();

$hora = date("H:i:s");
error_log("Accediendo  $hora !!!! \n", 3, "log.txt");
$usuario = $_POST['usuario'];
$password = $_POST['password'];
var_dump($_SERVER['REQUEST_METHOD']);
$db = new DB();
$msj = Authenticar::autenticar($usuario, $password, $db);

if ($msj === false) {
    $msj= ['status'=> 'error',
            'message'=> 'Credenciales inválidas. La autenticación ha fallado.',
            'data'=> null
    ];
    var_dump($msj);
    http_response_code(401);
    echo json_encode($msj);
}
else {
    http_response_code(200);
    var_dump($msj);
    echo json_encode($msj);
}



?>
