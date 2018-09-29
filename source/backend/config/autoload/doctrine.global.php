<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => 'db',
                    'port'     => '3306',
                    'dbname'   => 'web_db',
                    'charset'  => 'utf8',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8'
                    ]
                ],
            ],
        ],
        'migrations_configuration' => [
            'orm_default' => [
                'directory' => 'data/Migrations',
                'name'      => 'Doctrine Database Migrations',
                'namespace' => 'Migrations',
                'table'     => 'migrations',
            ],
        ],
    ],
];
