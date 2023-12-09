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
echo json_encode(array('acción' => "Insertando datos, mensaje : -$rtdo-"));
