<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
session_start();
require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();

(require '../config/middleware.php')($app);
(require '../config/routes.php')($app);

$app->run();
