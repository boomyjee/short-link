<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

session_start();
require __DIR__ . '/../vendor/autoload.php';

if (env('APP_DEBUG')) {
    ini_set('display_errors','on');
    error_reporting(E_ALL);
}

/** @var ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

AppFactory::setContainer($container);
$app = AppFactory::create();


$app->setBasePath((function () {
    if (($publicFolderPos = stripos($_SERVER['REQUEST_URI'],'public')) === false) {
        return '';
    } 

    return substr($_SERVER['REQUEST_URI'],0,$publicFolderPos).'public';

})());

(require '../config/middleware.php')($app);
(require '../config/routes.php')($app);

$app->run();
