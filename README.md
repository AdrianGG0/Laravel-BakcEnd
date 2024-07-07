

*************************Instalacion*********************************


Se utiliazo Laravel v11.14.0 (PHP v8.3.6) para este proyecto

Para el .env esta es la configuracion.

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mydb
    DB_USERNAME=root
    DB_PASSWORD=123

    php artisan migrate

Crear un usuario.
    php artisan db:seed

Instalar dependencia.
    composer require laravel/sanctum  <---- Token (no es requerido)

    composer dump-autoload
    composer install
    php artisan migrate


Se debe crear la tabla de logs.

    CREATE TABLE logs(id_log int primary key auto_increment, section varchar(50), messege varchar(50), query text, date varchar(50), id varchar(20) );





*********************************-***************************************
********************************USO**************************************
*********************************-***************************************

    1.- Login

![Hacer el loggin](/public/image0.png)  ctrl + clic abre la imagen  <-----------------------------------

Se consulta esta ruta con un metodo POST: http://127.0.0.1:8000/api/login

En el body se agrega :
    {
        "email":"test@example.com",
        "password":"password",
        "device":"hola" 

    }

****Si no se agregan el body este regresa: Unauthorized
****Se debe agregar por lo menos 3 valores de lo contrario regresa: Unauthorized

Se regresa el token y este se utiliza para los demas metodos.




    2.- Ver todos los customers

![Ver Todos](/public/image1.png)  ctrl + clic abre la imagen  <-----------------------------------

Se consulta esta ruta con un metodo GET: http://127.0.0.1:8000/api/customers

Y se agrega el token en Auth





    3.- Ver solo un customer

![Ver uno](/public/imagec1.png)  ctrl + clic abre la imagen  <-----------------------------------
![Ver uno](/public/imagec2.png)  ctrl + clic abre la imagen  <-----------------------------------

Se consulta esta ruta con un metodo GET: http://127.0.0.1:8000/api/customer

Se agrega el token en Auth. En el body se agrega :
    {
        "email":"test@example.com",
    }

    o

    {
        "dni":"1234",
    }




    4.- Elimninar customer

![Eliminar](/public/image3.png)  ctrl + clic abre la imagen  <-----------------------------------

Se consulta esta ruta con un metodo DELETE: http://127.0.0.1:8000/api/delete/2

Se agrega el token en Auth. 





    5.- Ver los usuarios

![Usuarios](/public/image4.png)  ctrl + clic abre la imagen  <-----------------------------------

Se consulta esta ruta con un metodo GET: http://127.0.0.1:8000/api/users
Se agrega el token en Auth. 




*********************************-***************************************
**************************Explicacion del codigo*************************
*********************************-***************************************

1.- Rutas

    Se cuenta con 6 rutas, 5 de ellas utilizan middleware, la sobrante no lo utiliza ya que es el login.


2.- Controladores

    Se tiene 3 controladores, el de login que hace el logeo al programa mediante la validacion el base de datos y asigna el token.
    El controlador de user, que simplemente es para ver lo usuarios que se encuentran en base.
    El controlador de customers, que es donde esta el crud.

3.- Metodos

    En los metodos de customers se valida que las variables recividads no contrengan SQL al mismo tiempo de que se validas
    en caso de venir vacias(dependiendo su uso). Ademas depues de elimnar o insertar un nuevo customer se agrega un log a base de datos (logs de entrada).



