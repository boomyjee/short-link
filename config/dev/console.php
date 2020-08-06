<?php declare(strict_types=1);

use Doctrine\Migrations;

return [

    'config' => [
        'console' => [
            'commands' => [
                Migrations\Tools\Console\Command\DiffCommand::class,
                Migrations\Tools\Console\Command\GenerateCommand::class,
            ],
        ],
    ],
];
