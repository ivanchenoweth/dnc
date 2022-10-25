# Formato de Nececidades de Capacitacion (DNC) para el Centro de Capacitación CECAP

> Proyecto Publico FLOSS para elaborar un cuestionario para las necesidades de capacitar al Personal

> DNC fue elaborado con el propósito  de elaborar el programa ANUAL de capacitación 2022 para el personal que forma parte de la Administración Pública Estatal y buscando ofrecer nuestro servicio lo más cercano a tus necesidades de capacitación y actualización, te solicitamos completes la información que te permita mejorar tu desempeño en el puesto que actualmente desempeñan.

> Puede ser aplicado para cualquier empresa privada o publica

## Requisitos :

Tener configurado o instalado en forma nativa o virtual en la plataforma del codigo fuente:

* PHP Ver>7.3 
> https://windows.php.net/download
  > Asegurarse que las extensiones estan activas (editar php.ini):
  extension=openssl
  extension=pdo_mysql 
  Locate the file with: 
  php -i | find/i"configuration file"  
* Composer version 2.2.4 2022-01-08 12:30:42
> https://getcomposer.org/doc/00-intro.md#installation-windows
* mariadb >10.3 | MySQL version: 5.6.34 (operando en el puerto default 3306)
> https://mariadb.org/download/?t=mariadb&p=mariadb&r=10.6.5&os=windows&cpu=x86_64&pkg=zip&m=xtom_fre

## Instalacion y configuracion
### Paso 1 .- Instalar laravel y la aplicacion web
`git clone https://github.com/ivanchenoweth/dnc`
`composer install --ignore-platform-req=ext-gd --ignore-platform-req=ext-fileinfo`
### Paso 2 .- Configuracion con el DBMS:
 copiar el archivo '.env.example' como '.env'
 editar el archivo .env con las credenciales del servidor SQL:
 DB_DATABASE=dnc_db
 DB_USERNAME=root
 DB_PASSWORD=usbw
### Paso 3 .-  Crear la base de datos **dnc_db** dentro del gestor

### Paso 4 .-  Ejecutar la migracion y los datos iniciales (seeders)
`php artisan migrate:fresh --seed`

### Paso 5 .-  Generar llave de la app
`php artisan key:generate`

## Ejecutar la aplicacion web de forma local
### Paso 1.- Iniciar el servidor web de laravel:
`php artisan serve`
Hacer click en la siguiente URL
[http://127.0.0.1:8000](http://127.0.0.1:8000)

### Paso 2
Hacer click en la siguiente URL de acceso
[http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

### Paso 3 : teclear credenciales de administrador
admin@gmail.com
admin


## Notas adicionales
Se intenta utilizar las mejores practicas como son:

 Priebas unitarias (en desarrollo)
 Controles flacos (Skinny controllers)
 Uso de Repositorios
 Uso de Modelos
 Importacion y Exportacion de Datos con hojas de Excel
 

  Es un proyecto EN DESARROLLO, algunas opciones aun no funcionan
 para ingresar usuario admin@gmail.com contraseña admin
 NO usar giones bajos en los nombres de las tablas
 USAR la letra s al final de los nombres de las tablas (probar)
 NO usar mayusculas entre medio de los nombres de Repositorios o Modelos
usar MAYUSCULAS a la hora de importar formatos DNCs, quitar los acentos
en lasl columnas dep_o_ent, unidad_admva y area, ya que habrá problemas en los filtrox

pra subir a la nube
git add .
git commit -m "modif_20210507"
git push

Video de YOUTUBE del CRUD Laravel 8, ejemplo de EMpleados con Foto que sube a storage public/uploads
https://www.youtube.com/watch?v=9DU7WLZeam8

para ver rutas actvas
php artisan route:list

Le da un migrate:reset (drop all tables)
y crea las migraciones (php artisan migrate)
php artisan migrate:fresh

Genera los registros de Usuario Administrador y uno de prueba
php artisan db:seed


## running in heroku

Crear un proyecto nuevo en HEROKU 
en este caso se llama fodnc
Se amarra con el repositorio de github, en este caso cayi/dnc
Se crea una Pipeline, pero dentro de la pipeline esta una staggin
que es el icono de Hexagonal, aqui se ponen las variables de ambiente
que usara Laravel para conectarse a la base de datos, estas variables son:

APP_DEBUG true
APP_ENV production
APP_KEY base64:n/raCwFkyD2o2OthF8whDaXFwRX07odsAeRJBcFgFqA=
APP_NAME fodnc
APP_URL https://fondc.heroku.com
DB_CONNECTION pgsql
DB_PORT 5432
DB_HOST aaaa
DB_DATABASE xxx
DB_USERNAME yyyyy
DB_PASSWORD zzzz
DB_URL xxxyyzzzz


[Click Here](https://radiant-earth-84938.herokuapp.com)

## heroku CLI to go the bash

`$heroku git:remote -a dnc

`heroku run bash
php artisan migrate:refresh  
php artisan db:seed 


# Formato de Nececidades de Capacitacion (DNC) para el Centro de Capacitación CECAP

## Proyecto Publico para elaborar un cuestionario para las necesidades de capacitaci+on del Personal

## Requisitos :

Tener configurado o instalado en forma nativa o virtual en la plataforma del codigo fuente:

* PHP Ver>7.3 
> https://windows.php.net/download
  > Asegurarse que las extensiones estan activas (editar php.ini):
  extension=openssl
  extension=pdo_mysql 
  Locate the file with: 
  php -i | find/i"configuration file"  
* Composer version 2.2.4 2022-01-08 12:30:42
> https://getcomposer.org/doc/00-intro.md#installation-windows
* mariadb >10.3 | MySQL version: 5.6.34 (operando en el puerto default 3306)
> https://mariadb.org/download/?t=mariadb&p=mariadb&r=10.6.5&os=windows&cpu=x86_64&pkg=zip&m=xtom_fre

## Instalacion y configuracion
### Paso 1 .- Instalar laravel y la aplicacion web
`composer install --ignore-platform-req=ext-gd --ignore-platform-req=ext-fileinfo`
### Paso 2 .- Configuracion con el DBMS:
 copiar el archivo '.env.example' como '.env'
 editar el archivo .env con las credenciales del servidor SQL:
 DB_DATABASE=dnc_db
 DB_USERNAME=root
 DB_PASSWORD=usbw
### Paso 3 .-  Crear la base de datos **dnc_db** dentro del gestor

### Paso 4 .-  Ejecutar la migracion y los datos iniciales (seeders)
`php artisan migrate:fresh --seed`

### Paso 5 .-  Generar llave de la app
`php artisan key:generate`

## Ejecutar la aplicacion web de forma local
### Paso 1.- Iniciar el servidor web de laravel:
`php artisan serve`
Hacer click en la siguiente URL
[http://127.0.0.1:8000](http://127.0.0.1:8000)

### Paso 2
Hacer click en la siguiente URL de acceso
[http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

### Paso 3 : teclear credenciales de administrador
admin@gmail.com
admin


## Notas adicionales
Se intenta utilizar las mejores practicas como son:

 Priebas unitarias (en desarrollo)
 Controles flacos (Skinny controllers)
 Uso de Repositorios
 Uso de Modelos
 Importacion y Exportacion de Datos con hojas de Excel

 

  Es un proyecto EN DESARROLLO, algunas opciones aun no funcionan
 para ingresar usuario admin@gmail.com contraseña admin
 NO usar giones bajos en los nombres de las tablas
 USAR la letra s al final de los nombres de las tablas (probar)
 NO usar mayusculas entre medio de los nombres de Repositorios o Modelos
 

pra subir a la nube
git add .
git commit -m "modif_20210507"
git push

Video de YOUTUBE del CRUD Laravel 8, ejemplo de EMpleados con Foto que sube a storage public/uploads
https://www.youtube.com/watch?v=9DU7WLZeam8

para ver rutas actvas
php artisan route:list

Le da un migrate:reset (drop all tables)
y crea las migraciones (php artisan migrate)
php artisan migrate:fresh

Genera los registros de Usuario Administrador y uno de prueba
php artisan db:seed


## running in heroku

[Click Here](https://radiant-earth-84938.herokuapp.com)

## heroku CLI to go the bash

`$heroku git:remote -a dnc

`heroku run bash
php artisan migrate:fresh  --seed



