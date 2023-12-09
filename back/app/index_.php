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

$opcion = $_POST['submit'] ?? null;
var_dump($_POST);
switch ($opcion) {
    case "Insertar Datos":
        $db->insertar_datos();
        break;
    case "Validar":


        $nombre = htmlspecialchars(filter_input(INPUT_POST, 'nombre'));
        $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        JWTHandler::set_key($password);

        if ($db->validar_usuario($nombre, $password)) {
            // Autenticación exitosa, genera un JWT
            $data = array('usuario' => $nombre);
            $token = JWTHandler::generarToken($data);
            // Retorna el token como respuesta
            echo json_encode(array('token' => $token));
        } else {
            // Autenticación fallida
            header('HTTP/1.0 401 Unauthorized');
            echo json_encode(array('error' => 'Autenticación fallida'));
        }

        $msj = "Datos erróneos";
        break;
    default:


}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="auth.php" method="post">
    Nombre <input type="text" name="nombre" id="">
    Password <input type="text" name="password" id="">
    <input type="submit" value="Validar" name="submit">
</form>
<form action="auth.php" method="post">
    <input type="submit" value="Insertar Datos" name="submit">
</form>
<?= $msj ?? "" ?>
</body>
</html>
