<?php declare(strict_types=1);

use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use Slim\Exception\HttpNotFoundException;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;

return static function (App $app): void {
    $app->addRoutingMiddleware();

    $container = $app->getContainer();

    $errorMiddleware = $container->get(ErrorMiddleware::class);
    $app->add($errorMiddleware);
    $notFoundErrorHandler = function (
        Psr\Http\Message\ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) use ($app, $container) {
        $response = $app->getResponseFactory()->createResponse();

        $message = $exception->getMessage();
        $response->withStatus(404);

        if($logErrors) {
            $logger = $container->get(LoggerInterface::class);
            $logger->error($message, [
                'exception' => $exception,
                'url' => (string)$request->getUri(),
            ]);
        }

        $view = $container->get(Twig::class);

        return $view->render($response,'errors/404.html.twig',['error'=>$message]);
    };

    $errorMiddleware->setErrorHandler(HttpNotFoundException::class, $notFoundErrorHandler);


    $app->add(Guard::class);

};
