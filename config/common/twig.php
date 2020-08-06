<?php

use App\Frontend\FrontendUrlTwigExtension;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

return [
    Twig::class => function (ContainerInterface $container): Twig {
        $config = $container->get('config')['twig'];
        $twig = Twig::create($config['template_dirs'],
            [
                'cache' => $config['debug'] ? false : $config['cache_dir'],
                'debug' => $config['debug'],
                'strict_variables' => $config['debug'],
                'auto_reload' => $config['debug'],
            ]
        );
        $twig->getEnvironment()->addFunction(new TwigFunction('base_url',function (string $str = ''){
            return env('APP_URL').$str;
        }));
        $twig->getEnvironment()->addFunction(new TwigFunction('app_name',function (){
            return env('APP_NAME');
        }));
        return $twig;
    },

    'config' => [
        'twig' => [
            'debug' => (bool)getenv('APP_DEBUG'),
            'template_dirs' => [
                FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../../templates',
            ],
            'cache_dir' => __DIR__ . '/../../var/cache/twig',
            'extensions' => [
            ],
        ],
    ],
];
