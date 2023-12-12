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
$db = new DB();
$msj = Authenticar::autenticar($usuario, $password, $db);

if ($msj === false) {
    http_response_code(401);
    $msj= ['status'=> 'error',
            'message'=> 'Credenciales inválidas. La autenticación ha fallado.',
            'data'=> null
    ];
    echo json_encode($msj);
}
else {
    http_response_code(200);
    echo json_encode($msj);
}



?>
