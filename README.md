# Proyecto Final de Ciclo - App InvoClient

¿Qué es InvoClient?
Es una software capaz de centralizar toda la información entre la empresa y el cliente. Este proyecto es una agrupación de tecnologías que permiten llevar a cabo las principales funciones de gestión de clientes de una empresa, de manera estructurada y eficiente.

## Instalación de la Aplicación 🚀

### Docker

Como requisito principal, tener instalado la versión de Docker correspondiente al sistema operativo. Tambien, clonar el código fuente de la rama invoclient_back del repositorio.

1. Ejecutar en la terminal este comando: docker pull mysql:8
2. Ejecutar en la terminal este comando: docker pull phpmyadmin:5.1-apache
3. Dentro del directorio raiz de invoclient-back, acceder a la carpeta docker mediante la terminal. A continuación, ejecutar este comando: ¨docker build -t ¨nombre tag¨ --file ¨dockerfile-php¨ .¨
4. Cambiar el valor definido en la propiedad volumes del servicio www dentro del fichero docker-compose.yml a "ruta del proyecto":/var/www/html
5. En el directorio docker del proyecto, ejecutar en la terminal ¨docker-compose up -d¨
6. Una vez iniciado los contenedores, acceder a la ruta: http://localhost:8001 y acceder con las siguientes credenciales. Usuario -> root, password -> root.
7. Dentro de la base de datos invoclient, accedemos a la pestaña importar. Una vez dentro, importar el archivo sql localizado en el directorio Docker de la carpeta raiz.
8. Acceder al directorio environments de la rama invoclient-front y modificar el valor del fichero environment.ts a ¨http://localhost:´puerto´/api¨ en la variable de entorno baseURL.
9. Ejecutar en la terminal el comando ng serve. A continuación, acceder a través del navegador a esta url: http://localhost:4200
10. Introducir las siguientes credenciales para acceder a la aplicación:
- Username: napegi1
- Password: lorem

### Local

1. Descargar el código fuente de la rama Invoclient-back. Como requisito, se necesita tener instalado el manejador de dependencias de PHP (composer).
2. Dentro del directorio del proyecto, ejecutar en la terminal ¨composer install¨
3. Una vez instaladas las dependencias, acceder al directorio public y ejecutar php -S localhost:¨puerto¨
4. Descargar el código fuente de la rama invoclient-front, realizar un npm install
5. Acceder al directorio environments y modificar el valor del fichero environment.ts a ¨http://localhost:´puerto´/api¨ en la variable de entorno baseURL.
5. Ejecutar en la terminal ng serve
6. Dentro de la aplicación, acceder estas credenciales:
- Username: napegi1
- Password: lorem

### Remoto

La aplicación esta alojada en un hosting llamado Netlify (https://invoclient-angular.netlify.app/). Acceder con estas credenciales:
- Usuario: napegi1
- Password: lorem

## Construido con 🛠️

- [Angular](https://angular.io/docs) - Aplicación
- [PHP](https://www.php.net/docs.php) - API REST
- [MYSQL](https://dev.mysql.com/doc/) - Servicio Base de Datos

## Dependencias 📚

- Json Web Token (JWT)
- PrimeNG
- Bootstrap

## Tecnologías
- Angular
- Docker
- MYSQL

## Autores ✒️

- **Nacho Pedrós Gil**

## Licencia 📄

Este proyecto está bajo la Licencia (CC-Creative-Comons).
