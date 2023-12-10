<?php
require "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;


$dotenv= Dotenv::createImmutable(__DIR__."/docker");
$dotenv->load();

$key = $_ENV['KEY'];
$payload = [
    'user' => 'Maria',
    'user_id' => 5,
    'rol' => "admin"
];

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($payload, $key, 'HS256');
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
print_r($decoded);