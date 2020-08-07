<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Csrf\Guard;

return [
    Guard::class => static function (ContainerInterface $container): Guard {
        return new Guard($container->get(ResponseFactoryInterface::class));
    },
];
