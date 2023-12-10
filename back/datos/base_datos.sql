CREATE DATABASE IF NOT EXISTS usuarios;
USE usuarios;

CREATE TABLE IF NOT EXISTS usuarios (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        nombre VARCHAR(50) unique NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol  VARCHAR(10) NOT NULL check (rol in('admin','usuario','gestor'))
    );

-- Insertar los usuarios de ejemplo
INSERT INTO usuarios (nombre, password,rol) VALUES
      ("maria", SHA2('maria', 256),"admin"),
      ("pedro", SHA2('pedro', 256),"admin"),
      ("lourdes", SHA2('lourdes', 256),"gestor"),
      ("luis", SHA2('luis', 256),"usuario");
