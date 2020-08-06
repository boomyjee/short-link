<?php

use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;

define('APP_ROOT', realpath(__DIR__ . '/../'));
Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

return [

    'displayErrorDetails' => true,
    'determineRouteBeforeAppMiddleware' => false,

    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'types' => [
                    UuidType::NAME => UuidType::class
                ],
            ],
        ],
// if true, metadata caching is forcefully disabled
        'dev_mode' => true,

// path where the compiled metadata info will be cached
// make sure the path exists and it is writable
        'cache_dir' => APP_ROOT . '/var/doctrine',

// you should add any other path containing annotated entity classes
        'metadata_dirs' => [APP_ROOT . '/src/Models'],

        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'port' => 3306,
            'dbname' => 'short_link',
            'user' => 'root',
            'password' => '',
            'charset' => 'utf8'
        ]
    ]

];
