<?php

require "vendor/autoload.php";

use Database\DB;
use Dotenv\Dotenv;
use Database\JWTHandler;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$db = new DB();
$rtdo =$db->insertar_datos();
echo json_encode(array('acción' => "Insertando datos, mensaje : -$rtdo-"));
