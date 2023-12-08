<?php

namespace Database;

use Dotenv\Exception\ValidationException;

class DB
{
    private \PDO $con;

    public function __construct()
    {
        $host = $_ENV['HOST'];
        $password = $_ENV['PASSWORD'];
        $port = $_ENV['PORT'];
        $user = $_ENV['USER_'];
        $database = $_ENV['DATABASE'];
        $dsn = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

        try {
            $this->con = new \PDO($dsn, $user, $password);
            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function validar_usuario($nombre, $password)
    {
        $sentencia = "select *  from usuarios where nombre =:nombre";
        $stmt = $this->con->prepare($sentencia);
        $stmt->execute([":nombre" => $nombre]);

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(\PDO::FETCH_OBJ);

            if (password_verify($password, $usuario->password))
                return true;
            else
                return false;
        }
        return false;
    }

    public function insertar_datos()
    {
        $sentencia = "select * from usuarios";
        try {
            $stmt = $this->con->prepare($sentencia);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $pass_maria = password_hash("maria", PASSWORD_BCRYPT);
                $pass_pedro = password_hash("pedro", PASSWORD_BCRYPT);
                $pass_lourdes = password_hash("lourdes", PASSWORD_BCRYPT);
                $pass_luis = password_hash("luis", PASSWORD_BCRYPT);
                $sentencia = <<<FIN
            INSERT INTO usuarios (nombre, password) VALUES
              ("maria", "$pass_maria"),
              ("pedro", "$pass_pedro"),
              ("lourdes", "$pass_lourdes"),
              ("luis", "$pass_luis");
FIN;
                $stmt = $this->con->prepare($sentencia);
                $stmt->execute();
            }

        } catch (\PDO_EXCPETION $e) {

            echo "<h1>Error " . $e->getmessage . "</h1>";
        }
    }


    public function get_usuarios()
    {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->con->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}