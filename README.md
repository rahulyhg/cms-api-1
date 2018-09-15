# Docker containers
This is a docker boiler plate for all my php project which run on Ubuntu 18.04 (LAMP)

1. Run a dev environment in docker
    - Apache2/PHP
    - MySQL
    - Redis (mainly for cache)
2. Create our image by using Dockerfile
3. Combine our image file with pre-made images (MySQL/Redis)
4. Assemble all to gather in (docker-compose.yml)
5. Create a shortcut way to build or run docker 

To build docker image: 
```docker build -t main/app -f ./docker/app/Dockerfile .```
To run image and create container:
```docker run -itd --rm --name app -p 8080:80 -v $(pwd)/application:/var/www/html main/app```
To track all logs which are sent to the docker output:
```docker logs -f app```


Zend App
==============================

what we need
------------
- Apigility Skeleton Application
- Installing Doctrine Components
- Install doctrine migration


Installing Doctrine Components
-----------
- run following command
```bash
$ ./dev composer require doctrine/doctrine-orm-module
```

Installation (Doctrine/Migration)
------------
- ```bash
    $ ./dev composer require doctrine/migrations
  ```
- in `config/autoload/global.php` add following config
```php
    'doctrine' => [        
        // migrations configuration
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
    ],
```
- then create `APP_DIR/data/Migrations` directory
- to run migrations command use
```bash
$ ./dev migrations
```

Installation (Apigility Skeleton Application)
------------

### Via Composer (create-project)

```bash
$ composer create-project -sdev zfcampus/zf-apigility-skeleton path/to/install
```

### NOTE ABOUT USING APACHE

Apache forbids the character sequences `%2F` and `%5C` in URI paths. However, the Zend App Admin
API uses these characters for a number of service endpoints. As such, if you wish to use the
Admin UI and/or Admin API with Apache, you will need to configure your Apache vhost/project to
allow encoded slashes:

```apacheconf
AllowEncodedSlashes On
```

This change will need to be made in your server's vhost file (it cannot be added to `.htaccess`).

### NOTE ABOUT OPCACHE

**Disable all opcode caches when running the admin!**

The admin cannot and will not run correctly when an opcode cache, such as APC or
OpCache, is enabled. Zend App does not use a database to store configuration;
instead, it uses PHP configuration files. Opcode caches will cache these files
on first load, leading to inconsistencies as you write to them, and will
typically lead to a state where the admin API and code become unusable.

The admin is a **development** tool, and intended for use a development
environment. As such, you should likely disable opcode caching, regardless.

When you are ready to deploy your API to **production**, however, you can
disable development mode, thus disabling the admin interface, and safely run an
opcode cache again. Doing so is recommended for production due to the tremendous
performance benefits opcode caches provide.

### NOTE ABOUT DISPLAY_ERRORS

The `display_errors` `php.ini` setting is useful in development to understand what warnings,
notices, and error conditions are affecting your application. However, they cause problems for APIs:
APIs are typically a specific serialization format, and error reporting is usually in either plain
text, or, with extensions like XDebug, in HTML. This breaks the response payload, making it unusable
by clients.

For this reason, we recommend disabling `display_errors` when using the Zend App admin interface.
This can be done using the `-ddisplay_errors=0` flag when using the built-in PHP web server, or you
can set it in your virtual host or server definition. If you disable it, make sure you have
reasonable error log settings in place. For the built-in PHP web server, errors will be reported in
the console itself; otherwise, ensure you have an error log file specified in your configuration.

`display_errors` should *never* be enabled in production, regardless.


### Docker

Start the container:

```bash
$ ./dev start
```

Access Zend App from `http://localhost:8080/` or `http://<boot2docker ip>:8080/` if on Windows or Mac.

You may also use the provided `Dockerfile` directly if desired.

Once installed, you can use the container to update dependencies:

```bash
$ ./dev composer update
```

Or to manipulate development mode:

```bash
$ ./dev composer development-enable
$ ./dev composer development-disable
$ ./dev composer development-status
```

QA Tools
--------

The skeleton ships with minimal QA tooling by default, including
zendframework/zend-test. We supply basic tests for the shipped
`Application\Controller\IndexController`.

We also ship with configuration for [phpcs](https://github.com/squizlabs/php_codesniffer).
If you wish to add this QA tool, execute the following:

```bash
$ ./dev composer require --dev squizlabs/php_codesniffer
```

We provide aliases for each of these tools in the Composer configuration:

```bash
# Run CS checks:
$ ./dev composer cs-check
# Fix CS errors:
$ ./dev composer cs-fix
# Run PHPUnit tests:
$ ./dev composer test
```
