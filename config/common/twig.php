<?php

use App\Frontend\FrontendUrlTwigExtension;
use Psr\Container\ContainerInterface;
use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Markup;
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
            return base_url($str);
        }));
        $twig->getEnvironment()->addFunction(new TwigFunction('app_name',function (){
            return env('APP_NAME');
        }));

        $csrfGuard = $container->get(Guard::class);

        $twig->getEnvironment()->addFunction(new TwigFunction('csrf_token_inputs',function () use ($csrfGuard) {
            $html = '';
            $html .= '<input type="hidden" name="'.$csrfGuard->getTokenNameKey().'" value="'.$csrfGuard->getTokenName().'">';
            $html .= '<input type="hidden" name="'.$csrfGuard->getTokenValueKey().'" value="'.$csrfGuard->getTokenValue().'">';
            return new Markup($html, "UTF-8");

        }));
        $twig->getEnvironment()->addFunction(new TwigFunction('csrf_token_name',function () use ($csrfGuard) {
            return $csrfGuard->getTokenName();
        }));

        return $twig;
    },

    'config' => [
        'twig' => [
            'debug' => (bool)env('APP_DEBUG'),
            'template_dirs' => [
                FilesystemLoader::MAIN_NAMESPACE => __DIR__ . '/../../templates',
            ],
            'cache_dir' => __DIR__ . '/../../var/cache/twig',
            'extensions' => [
            ],
        ],
    ],
];
