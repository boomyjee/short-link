<?php

declare(strict_types=1);

use Doctrine\Migrations;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;

return [
    'config' => [
        'default' => [
            'debug' => (bool)getenv('APP_DEBUG'),
            'mode' => getenv('APP_ENV'),
            'logErrors' => true,
            'logErrorsDetails' => true,
        ],
    ],
];
