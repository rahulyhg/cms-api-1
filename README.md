# Docker containers
This is a docker boiler plate for all my php project (ZF3) which run on Ubuntu 18.04 (LAMP)
Run a dev environment in docker
    - Apache2/PHP7.2
    - MySQL
    - Redis (mainly for cache)
All shortcut code are available in `./dev` bash file

Zend App
==============================
- After clone the repository, run docker by type the following command:
```bash
$ ./dev start
```
- to install all dependencies of ZF3 install composer
```bash
$ ./dev composer install
```
- Install all node dependencies
```bash
$ ./dev npm install
```
- bundle all assets
```bash
$ ./dev grunt
```
- copy `source/backend/config/development.config.php.dist` to `source/backend/config/development.config.php` if you want
to activate development mode
- for developing your app active development enviroment by running following command
```bash
$ ./dev composer development-enable
```
- to deploy your app change environment into product
```bash
$ ./dev composer development-disable
```

Zend Framework Customized Commands
-------------
- Create module
```bash
$ ./dev zf module -c blog
```
- Remove module
```bash
$ ./dev zf module -r blog
```

Doctrine Components
-----------
- rename ./source/config/autoload/doctrine.local.php.dist to doctrine.local.php and change db username and pass if
it is necessary
- configuration for each module
```php
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ]
```

- get list of all migrations command `./dev doctrine-module orm:schema-tool:create`
- get list of all migrations command `./dev doctrine-module orm:schema-tool:update --force`
- get list of all migrations command `./dev doctrine-module orm:validate-schema`

Doctrine/Migration
------------
- get list of all migrations command `./dev doctrine-module`
- create a new migration `./dev doctrine-module migration:generate`
- commit all new migrations `./dev doctrine-module migration:migrate`
- commit all new migrations `./dev doctrine-module migrations:execute YYYYMMDDHHMMSS --down`
- commit all new migrations `./dev doctrine-module migrations:execute YYYYMMDDHHMMSS --up`
- migrate up to the last `./dev doctrine-module migrations:migrate latest`
- migrate up to the next `./dev doctrine-module migrations:migrate next`
- migrate down to the prev `./dev doctrine-module migrations:migrate prev`
- migrate down to the first `./dev doctrine-module migrations:migrate first`
- migrate up to 3 `./dev doctrine-module migrations:migrate current+3`
- migrate down to 3 `./dev doctrine-module migrations:migrate current-3`


Apigility
------------
if you are in development mode you can browse admin panel of apigility by going to `http://localhost:8080/apigility/ui/`


Docker
-----------
To build docker image: 
```docker build -t main/app -f ./docker/app/Dockerfile .```
To run image and create container:
```docker run -itd --rm --name app -p 8080:80 -v $(pwd)/application:/var/www/html main/app```
To track all logs which are sent to the docker output:
```docker logs -f app```

Start the container:

```bash
$ ./dev start
```

Access Zend App from `http://localhost:8080/` or `http://<boot2docker ip>:8080/` if on Windows or Mac.
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
