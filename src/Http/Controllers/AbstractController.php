<?php declare(strict_types=1);

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class AbstractController
{

    /** @var ContainerInterface */
    protected $container;
    /** @var Twig */
    protected $view;
    /**@var EntityManager */
    protected $em;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get(Twig::class);
        $this->em = $container->get(EntityManagerInterface::class);
    }

    public function render(Response $response,$view,$params = []){
        return $this->view->render($response, $view, $params);
    }

}
