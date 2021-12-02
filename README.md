<h1>Guia de instalacion del proyecto</h1>

<h3>Paso 1</h3> 
Iniciar el programa Laragon y abrir una terminal para empezar a clonar el repositorio del proyecto con el comando 'git clone https://github.com/MatiasCusinato/Repocancha.git'
<br><br>

<h3>Paso 2</h3> 
Una vez clonado el repositorio, ingresar a la carpeta del mismo (con 'cd Repocancha') y abrir 1 terminal más: una para ingresar a la carpeta canchaback, y otra para canchafront. Se ingresa a una carpeta con el comando: 'cd canchaback'.
<br><br>

<h3>Paso 3</h3> 
Luego, abriras un IDE o editor de texto como Visual Studio Code o Sublime Text, tendras que abrir la carpeta del proyecto a traves del IDE, cuya ruta deberia ser: "DISCO-X:\laragon\www\Repocancha". Una vez abierto el proyecto, deberas buscar dentro de la carpeta canchaback, un archivo llamado '.env.example' y tendras que copiar todo su contenido para luego pegarlo dentro de otro archivo llamado '.env', el cual tendras que crear en la misma carpeta de canchaback, al mismo nivel que el archivo 'env.example'
<br><br>

<h3>Paso 4, carpeta canchaback:</h3> 
En la terminal que posee la carpeta canchaback, correr el comando 'composer i' para instalar las dependencias de composer. Terminada la instalacion, correr el comando 'php artisan key:Generate'. Generada la 'key', deberas crear una base de datos con el nombre de: dbcanchaback
Luego de crear la BD, volve al terminal y ejecuta el comando 'php artisan migrate:refresh --seed' para generar las migraciones y sus seeders en la Base de datos. Por ultimo, deberas ingresar el comando 'php artisan serve' para levantar un servidor localhost.
<br><br>


<h3>Paso 5, carpeta canchafront:</h3> 
En la segunda terminal, la que usara la carpeta canchafront, ejecuta el comando 'npm i', para instalar las dependencias de npm. Una vez instalado todo, corre el comando 'npm audit fix'. Ahora tenes que levantar el proyecto VUE con el comando 'npm run serve'. Abri el navegador e ingresa a http://localhost:8080/login
<br><br>

Seguidos estos pasos, para usar el sistema como administrador o encargado de una cancha, deberas LOGUEARTE desde la vista http://localhost:8080/#/login con los siguientes datos:
    -Email: 'pablo@gmail.com'
    -Contraseña: 'pabloadmin'
<br><br>

¡Genial, seguidos todos estos pasos ya podes usar el sistema como un encargado de un club!.