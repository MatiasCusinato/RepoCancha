<h1>Guia de instalacion del proyecto</h1>

<h3>Paso 1</h3> 
Abrir el programa Laragon y su terminal para clonar el repositorio del proyecto(https://github.com/MatiasCusinato/Repocancha.git)

<h3>Paso 2</h3> 
Una vez clonado el repositorio, ingresar a la carpeta del mismo (con 'cd Repocancha') y abrir 2 terminales o consolas: una para ingresar a la carpeta canchaback, y otra para canchafront. Se ingresa con el comando: cd "nombre-de-carpeta".

<h3>Paso 3, carpeta canchaback:</h3> 
En la terminal que posee la carpeta canchaback, correr el comando 'composer i' para instalar las dependencias de composer. Terminada la instalacion, correr el comando 'php artisan key:Generate'. Generada la 'key', deberas crear una base de datos con el nombre de: dbcanchaback
Luego de crear la BD, volver al terminal y ejecutar el comando 'php artisan migrate:refresh --seed' para generar las migraciones y sus seeders en la Base de datos. Por ultimo, deberas ingresar el comando 'php artisan serve' para levantar un servidor localhost.

<h3>Paso 4, carpeta canchafront:</h3> 
En la segunda terminal, la que usara la carpeta canchafront, ejecuta el comando 'npm i', para instalar las dependencias de npm. Una vez instalado todo, corre el comando 'npm audit fix'. Ejecutados los dos comandos anteriores, levantar el proyecto VUE con el comando 'npm run serve'.

Seguidos estos pasos, para usar el sistema como administrador o encargado de una cancha, deberas registrarte como administrador del club 4, desde la vista http://localhost:8080/#/registro . 
Luego de eso, inicia sesion en el sistema a traves del http://localhost:8080/#/login
Genial, seguidos todos estos pasos podras usar el sistema como un administrador!.

