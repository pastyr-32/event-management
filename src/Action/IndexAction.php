<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Parsedown;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class IndexAction
 * @package Nerdery\Action
 */
class IndexAction
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Request  $request
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Request $request, Response $response)
    {
        $markdown = file_get_contents('README.md');

        /** @var Parsedown $parser */
        $parser = new Parsedown();
        $content = $parser->text($markdown);

        $response->getBody()->write($content);
        return $response;

        /*$routes = array_reduce($this->app->getContainer()->get('router')->getRoutes(), function ($target, $route) {
            $target[$route->getPattern()] = [
                'methods' => json_encode($route->getMethods()),
                'callable' => $route->getCallable(),
                'middlewares' => json_encode($route->getMiddleware()),
                'pattern' => $route->getPattern(),
            ];
            return $target;
        }, []);
        die(print_r($routes, true));*/
    }
}