<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Ramsey\Uuid\Uuid;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Slim\Views\Twig;


class PageController extends AbstractController
{

    public function view(Request $request, Response $response, $args)
    {
        $alias = $args['alias'] ?? null;
        if (!$alias || !in_array($alias, $this->getPages())) {
            throw new HttpNotFoundException($request, 'Page not found');
        }
        return $this->render($response,'pages/'.$alias.'.html.twig');
    }

    protected function getPages()
    {
        return [
            'terms-of-service',
            'privacy-policy'
        ];
    }

}
