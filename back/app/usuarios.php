<?php

require "vendor/autoload.php";

use Database\DB;
use Dotenv\Dotenv;
use Database\JWTHandler;
use Firebase\JWT;

//ini_set("display_errors", true);
//error_reporting(E_ALL);

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


$db = new DB();

$usuarios = $db->get_usuarios();

// Devolver la respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($usuarios);
