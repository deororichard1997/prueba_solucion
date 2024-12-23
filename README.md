# prueba_solucion APi laravel v.10
Requisitos
- [PHP >= 8.1](https://www.php.net/)
- [Composer](https://getcomposer.org/)
- [Laravel CLI](https://laravel.com/docs/10.x#installation-via-composer)
- [MySQL o MariaDB](https://www.mysql.com/)
- [Node.js y NPM](https://nodejs.org/)

La rama master es la que contiene el código

Pasos para la correo proyecto en local
- 1- clonar el repositorio
- 2- Ubicarse en la carpeta del royecto y ejecutar el comando: composer install
- 3- Configurar variabes de entorno
- 4- Generar la clave de la aplicacion con el siguiente comando: php artisan key:generate
- 5- Correr las migraciones con el siguiente comando: php artisan migrate
- 6- Levantar el servicio con el siguiente comando: php artisan serve

Rutas de la API

- Iniciar sesión: Tipo de ruta: POST: http://127.0.0.1:8000/api/login
- Cerrar sesión: Tipo de ruta: POST: http://127.0.0.1:8000/api/logout
- Restabelcer contraseña: Tipo de ruta: POST: http://127.0.0.1:8000/api/restablecer-password
- (utliilar el token para las sgtes soliciturdes)
- Guardar info del usuario: Tipo de ruta: POST: http://127.0.0.1:8000/api/usuarios/store
- Mostrar info del usuario: Tipo de ruta: GET: http://127.0.0.1:8000/api/usuarios/{id}
- Actualizar info del usuario: Tipo de ruta: PUT: http://127.0.0.1:8000/api/usuarios/{id} enviar info del usuario en el body
- Eliminar info del usuario: Tipo de ruta: DELETE: http://127.0.0.1:8000/api/usuarios/{id}
