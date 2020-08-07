<?php declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv(true);
$dotenv->loadEnv(__DIR__.'/.env');

function env(string $key) {
    return getenv($key);
}

function base_url(string $url = '') {
    return env('APP_URL') . $url;
}
