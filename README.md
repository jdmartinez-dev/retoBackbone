## Reto Backbone

- Lo primero que hice fue analizar la información que se me entrego como referencia para ubicar cuáles eran las relaciones necesarias para construir el JSON esperado. De esta forma, pude determinar que información era necesaria a partir de los datos y que tablas y modelos era necesario crear.
- Genere las tablas [States] [municipalities] [zipcodes] [settlements] [settlement_types] y a cada una su respectivo modelo.
- Tome como base la tabla [zipcodes] porque de aquí obtengo las relaciones necesarias como (settlements, municipality) y (federal_entity) que la obtengo a partir de [municipalities] por su relación con [states].
- De esta manera, cuando realizo una petición sobre el modelo de (zipcode) para buscar uno en específico, este modelo me trae todos los datos relacionados y necesarios que arman el json de manera automática.

## Acerca del proyecto

En este apartado se encuentran los pasos a seguir para realizar la intalacion del proyecto:

- Clonar repositorio:
	- `git clone https://github.com/jdmartinez-dev/retoBackbone.git`
- Creamos una base de datos para usar con el proyecto.
- Ir a la raiz del proyecto: 
	- `cd retoBackbone`
- Instalamos toda la paquetería necesaria para nuestro proyecto mediante **composer**:
	- `composer install`
- Duplicamos **.env.example** y lo dejamos **.env** `cp .env.example .env` y procedemos a editar **.env** para aplicar nuestras variables de entorno. Para este paso solo será necesario configurar:
	- `APP_URL` en caso de ser necesario al aplicar un virtualHost o dominio público.
	- Variables de conexión a la base de datos, como son la serie de `DB_*` (Host, Port, Database, Username, Password)
- Luego ejecutamos este comando `php artisan key:generate` para generar la key del proyecto.
- Aplicamos los permisos sobre la carpeta **storage**:
	- `sudo chmod -R 775 storage && sudo chgrp -R www-data storage`
- Aplicamos las migraciones de la base de datos:
	- `php artisan migrate`
- Con el siguiente comando podremos importar la información que necesitamos para utilizar la API. `php artisan import:zipcodes`

Con estos pasos ya podremos hacer uso de nuestra API, ejemplo:
- **Local Endpoint con VirtualHost**
	- `http://locahost/api/zip-codes/{zip_code}`
	- `http://retobackbone.local/api/zip-codes/{zip_code}`
- **Public Endpoint**
	- `https://retobackbone.jmartinezn.com/api/zip-codes/{zip_code}`




<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
