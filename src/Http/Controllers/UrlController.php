<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class UrlController extends AbstractController
{


    public function index(Request $request, Response $response)
    {
        return $this->render($response, 'home.html.twig', ['error' => false]);
    }

    public function create(Request $request, Response $response)
    {
        $body = $request->getParsedBody();
        $url = $body['url'] ?? null;
        if (!$url || !filter_var($body['url'], FILTER_VALIDATE_URL)) {
            return $this->render($response, 'home.html.twig', ['error' => 'Url is empty or invalid']);
        }
        $link = new ShortLink();
        $uuid = Uuid::uuid4();
        $link->id = $uuid;
        $link->hash = substr(md5($uuid->toString() . $body['url']), 0, 5);
        $link->url = $url;
        $this->em->persist($link);
        $this->em->flush();
        return $response->withStatus(302)->withHeader('location', '/view/' . $link->hash);
    }

    public function show(Request $request, Response $response, $args)
    {
        $hash = $args['hash'] ?? null;
        if (!$hash) {
            throw new HttpNotFoundException($request, "link with hash `{$hash}` not found");
        }

        $link = $this->findLinkByHash((string)$hash);
        if (!$link) {
            throw new HttpNotFoundException($request, "link with hash `{$hash}` not found");
        }

        return $this->render($response, 'created.html.twig', ['link' => $link]);
    }

    public function track(Request $request, Response $response, $args)
    {
        return $this->render($response, 'track.html.twig');
    }

    public function clicks(Request $request, Response $response, $args)
    {
        $params = $request->getQueryParams();
        $url = $params['url'] ?? null;
        if (!$url) {
            throw new HttpNotFoundException($request, "link not provided");
        }
        $hash = substr($url,-5);
        $link = $this->findLinkByHash((string)$hash);
        if (!$link) {
            throw new HttpNotFoundException($request, "link with hash `{$hash}` not found");
        }

        return $this->render($response,'stats.html.twig',['clicks'=>$link->clicks]);
    }

    public function handle(Request $request, Response $response, $args)
    {
        if (empty($args['hash'])) {
            throw new HttpNotFoundException($request, "link with hash `{$args['hash']}` not found");
        }
        $hash = $args['hash'];
        $link = $this->findLinkByHash($hash);
        if (!$link) {
            throw new HttpNotFoundException($request, "link with hash `{$hash}` not found");
        }
        $link->clicks++;
        $this->em->persist($link);
        $this->em->flush();

        return $response->withStatus(302)->withHeader('location', $link->url);
    }

    protected function findLinkByHash(string $hash)
    {
        return $this->em->getRepository(ShortLink::class)
            ->findOneBy(['hash' => $hash]);
    }
}
