# Creación de una API con php para autenticar

Este es un proyecto para crear una api para autenticar      
Esta api retornará un jwt si las credenciales recibidas son correctas     
En sí mismo el proyecto utiliza diferentes tecnologías (docker, React en front, PHP en back con composer ).   

 
## Poner en marcha el proyecto  
1. Descargarlo (clonándolo o haciendo un fork)        

```git clone https://github.com/MAlejandroR/probando_jwt_api_auth.git ```

2. Copia el fichero __.env__
 Copia el fichero env a .env para que se usen las variables de entorno creadas    
 Puedes modificar los valores según desees:      

```cp env .env```

En el terminal en la carpeta donde hayas descargado el proyecto, que estará el fichero ___docker-compose.yaml___ levanta los contenedores creados.    
``` docker compose up ```
Para acceder http://localhost8080 Si le pasas un usuario registrado debería de retornar un token    
http://localhost8081 Para acceder a phpmyadmin (ver credenciales en el ficher ___.env___)    



3. Para crear usuarios se aporta un pequeño script que debes de ejectuar desde el navegador. Si ya estuvieran no los creará.    
   4. Creará 4 usuarios: maria, luis, pedro y lourdes con el mismo password que el nombre     
````bash
   http://localhost:8080/inserta_usuarios.php 
````
También podrías realizar esta acción desde el front. Retorna un json (mira el código)

4.- Para la parte del front ve a la carpeta y levanta el servidor con npm

````cd CARPETA_PROYECTO\front\my-react-app\src
    npm start
````
Levantará por el puerto 3000



## docker
Creamos un docker-compose-yaml para establecer el ambiente de mysql.    
Se abre el puerto 23306 para mysql y el 8081 php phpmyadmin. En realidad el 23306 no se usa, ya que accede directamente al contenedor

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
4.- 
