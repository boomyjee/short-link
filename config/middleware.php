<?php declare(strict_types=1);

use Slim\App;

return static function (App $app): void {
    $app->addRoutingMiddleware();

    $config = $app->getContainer()->get('config')['default'];

    $errorMiddleware = $app->addErrorMiddleware($config['debug'], $config['logErrors'], $config['logErrorsDetails']);
    $notFoundErrorHandler = function (
        Psr\Http\Message\ServerRequestInterface $request,
        \Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) use ($app) {
        $response = $app->getResponseFactory()->createResponse();

        $message = $exception->getMessage();
        $response->withStatus(404);
        $container = $app->getContainer();
        $view = $container->get(\Slim\Views\Twig::class);

        return $view->render($response,'errors/404.html.twig',['error'=>$message]);;
    };

    $errorMiddleware->setErrorHandler(\Slim\Exception\HttpNotFoundException::class, $notFoundErrorHandler);

};
