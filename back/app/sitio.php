
<?php



require "vendor/autoload.php";

use Database\JWTHandler;

use Dotenv\Dotenv;
use Firebase\JWT;

$dotenv= Dotenv::createImmutable(__DIR__."/docker");
$dotenv->load();
$key = $_ENV['KEY'];
error_log("En sitio.php\n",3,"log.txt");
error_log("_____________________________________\n",3,"log.txt");
$server = print_r($_SERVER,1);
$cookies = print_r($_COOKIE,1);
error_log("KEY = -$key-\n",3,"log.txt");
//error_log("Server: $server\n",3,"log.txt");
//error_log("cookies: $cookies\n",3,"log.txt");

// Verificar token
$token = $_SERVER["HTTP_AUTHORIZATION"] ?? $_COOKIE['token']??"";
error_log("token en sitio.php: -$token-\n",3,"log.txt");
try {
    JWTHandler::set_key($key);
    $decoded = JWTHandler::verificarToken($token);;
    $usuario = print_r($decoded,1);
    error_log("usuario: $usuario",3,"log.txt");
// Token válido, continuar con la lógica de la ruta protegida
    echo json_encode(array("mensaje" => "Ruta protegida, bienvenido " . $decoded->usuario));
} catch (Exception $e) {
// Token inválido
    error_log("Catch en sitio.php: " . $e . "\n", 3, "log.txt");
    http_response_code(401);
    echo json_encode(array("mensaje" => "Token inválido"));
}

?>