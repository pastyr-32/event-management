<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class ReadEvent
 * @package Nerdery\Action
 */
class ReadEvent
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
        $id = (int)$request->getAttribute('id');

        try {
            /** @var Event $event */
            $event = $this->em->getRepository(Event::class)->find($id);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $event) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        return $response->withJson($event, StatusCode::HTTP_OK);
    }
}