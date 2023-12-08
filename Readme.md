# Creación de una API con php para autenticar

Este es un proyecto para crear una api para autenticar
Esta api retornará un jwt si las credenciales recibidas son correctas
En sí mismo el proyecto utiliza diferentes tecnologías que vamos a repasar

## docker
Creamos un docker-compose-yaml para establecer el ambiente de mysql

Para las variables utilizamos un fichero ___.env___ que utilizaremos también para la conexión de la base de datos.
## Librerías

__Dotenv__
https://packagist.org/packages/vlucas/phpdotenv
Cargamos la librería en composer.json
```shell
 "require": {
    "vlucas/phpdotenv": "^5.6"
  },
```
![Banner](https://user-images.githubusercontent.com/2829600/71564012-31105580-2a91-11ea-9ad7-ef1278411b35.png)

<p align="center">
<a href="LICENSE"><img src="https://img.shields.io/badge/license-BSD%203--Clause-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/vlucas/phpdotenv"><img src="https://img.shields.io/packagist/dt/vlucas/phpdotenv.svg?style=flat-square" alt="Total Downloads"></img></a>
<a href="https://github.com/vlucas/phpdotenv/releases"><img src="https://img.shields.io/github/release/vlucas/phpdotenv.svg?style=flat-square" alt="Latest Version"></img></a>
</p>

*Para cargar los valores del fichero env actuamos de la siguiente manero:

1. Creamos un fichero ___.env___ con las constantes a utilizar
2. Establecemos la carga de este fichero en el programa
```php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
```
3. Accedemos a las constantes dese nuestro programa, por ejemplo en nuestro caso:
```php
        $host = $_ENV['HOST'];
        $password = $_ENV['PASSWORD'];
        $port = $_ENV['PORT'];
        $user = $_ENV['USER'];
```

