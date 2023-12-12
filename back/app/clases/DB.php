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
        $port = $_ENV['PORT_MYSQL'];
        $user = $_ENV['USER_'];
        $database = $_ENV['DATABASE'];
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
//        echo "<pre>";
//        var_dump($dsn);
//        var_dump($user);
//        var_dump($password);
//        echo "</pre>";

        try {
            $this->con = new \PDO($dsn, $user, $password);
            $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            error_log("Conectado a $database", 3, "log.txt");

        } catch (\PDOException $e) {
//            var_dump("<pre>$e</pre>");
            error_log("Problemas conectando" . $e->getMessage() . "\n", 3, "log.txt");
            echo json_encode(["error" => "Error conectando " . $e->getMessage()]);
            exit;
        }
    }

    public function validar_usuario($nombre, $password)
    {
        error_log("Validando usuario -$nombre- -$password-  \n", 3, "log.txt");
        $sentencia = "select *  from usuarios where nombre =:nombre";
        $stmt = $this->con->prepare($sentencia);
        $stmt->execute([":nombre" => $nombre]);

        if ($stmt->rowCount() > 0) {
            error_log("Usuario  -$nombre- Encontrado  \n", 3, "log.txt");
            $usuario = $stmt->fetch(\PDO::FETCH_OBJ);

            error_log("Password  -$usuario->password- con -$password-   \n", 3, "log.txt");

            if (password_verify($password, $usuario->password)) {
                error_log("Password  -$usuario->password-   OK \n", 3, "log.txt");
                return $usuario;
            } else {
                error_log("Password  -$usuario->password- NOOOOO   OK \n", 3, "log.txt");
                return false;
            }
        }
        return false;
    }

    public function update_usuario($id, $user, $password, $role)
    {
        $sentencia = <<<FIN
            UPDATE usuarios set nombre=?, password=?,rol=?
            where id = ?
FIN;
        try {

            $stmt = $this->con->prepare($sentencia);
            $stmt->execute([$user, $password, $role, $id]);
            if ($stmt->rowCount() == 1)
                return true;
            else
                return false;

        } catch (\PDO_EXCPETION $e) {
            return false;
        }

    }
    public function delete_usuario($id)
    {
        $sentencia = <<<FIN
            DELETE  FROM usuarios  where id = ?
FIN;
        try {

            $stmt = $this->con->prepare($sentencia);
            $stmt->execute([ $id]);
            if ($stmt->rowCount() == 1)
                return true;
            else
                return false;

        } catch (\PDO_EXCPETION $e) {
            return false;
        }

    }

    public
    function insertar_usuario($user, $password, $rol)
    {
        $sentencia = <<<FIN
            INSERT INTO usuarios (nombre, password,rol) VALUES
              (:user, :pass, :rol)
FIN;
        try {
            $stmt = $this->con->prepare($sentencia);
            $stmt->execute([":user" => $user, ":pass" => $password, ":rol" => $rol,]);
            if ($stmt->rowCount() == 1)
                return true;
            else
                return false;

        } catch
        (\PDO_EXCPETION $e) {
            return false;
        }

    }

    public
    function insertar_datos()
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
            INSERT INTO usuarios (nombre, password,rol) VALUES
              ("maria", "$pass_maria","admin"),
              ("pedro", "$pass_pedro","admin"),
              ("lourdes", "$pass_lourdes","gestor"),
              ("luis", "$pass_luis","usuario");
FIN;
                $stmt = $this->con->prepare($sentencia);
                $stmt->execute();
                return "Se han insertado" . $stmt->rowCount() . " filas";
            } else
                return "Ya había filas insertadas";

        } catch (\PDO_EXCPETION $e) {

            return false;
        }
    }


    public
    function get_usuarios()
    {
        $query = "SELECT * FROM usuarios";
        $stmt = $this->con->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public
    function get_usuario($id)
    {
        $query = "SELECT * FROM usuarios where id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->execute([":id" => $id]);
        if ($stmt->rowCount() > 0)
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        else
            return false;
    }
}