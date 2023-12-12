<?php

require "vendor/autoload.php";
use Database\DB;
use Dotenv\Dotenv;
use Database\JWTHandler;


//ini_set("display_errors", true);
//error_reporting(E_ALL);

$dotenv = Dotenv::createImmutable(__DIR__."/docker/");
$dotenv->load();





$db = new DB();

$rtdo =$db->insertar_datos();
if ($rtdo === false) {
    http_response_code(401);
    $msj= ['status'=> 'error',
        'message'=> 'No se ha podido realizar la inserción',
    ];
    echo json_encode($msj);
}
else {
    http_response_code(200);
    $msj= ['status'=> 'success',
          'message'=> $rtdo,
    ];
    echo json_encode($msj);
}


