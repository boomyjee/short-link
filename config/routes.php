<?php declare(strict_types=1);

use App\Http\Controllers\PageController;
use Slim\App;
use App\Http\Controllers\UrlController;

return static function (App $app): void {
    $app->get('/', UrlController::class.':index');
    $app->get('/page/{alias}', PageController::class.':view');
    $app->get('/view/{hash}', UrlController::class.':show');
    $app->get('/track', UrlController::class.':track');
    $app->get('/clicks', UrlController::class.':clicks');
    $app->post('/create', UrlController::class.':create');
    $app->get('/{hash:[a-z0-9]{5,5}}',UrlController::class.':handle');
};
