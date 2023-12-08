CREATE DATABASE IF NOT EXISTS usuarios;
USE usuarios;

CREATE TABLE IF NOT EXISTS usuarios (
                                        id INT AUTO_INCREMENT PRIMARY KEY,
                                        nombre VARCHAR(50) unique NOT NULL,
    password VARCHAR(255) NOT NULL
    );
-- Insertar los usuarios de ejemplo
INSERT INTO usuarios (nombre, password) VALUES
      ("maria", SHA2('maria', 256)),
      ("pedro", SHA2('pedro', 256)),
      ("lourdes", SHA2('lourdes', 256)),
      ("luis", SHA2('luis', 256));
