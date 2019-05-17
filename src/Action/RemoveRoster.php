<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Nerdery\Domain\Roster;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class RemoveRoster
 * @package Nerdery\Action
 */
class RemoveRoster
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
        $rosterId = (int)$request->getAttribute('rid');

        try {
            /** @var Roster $roster */
            $roster = $this->em->getRepository(Roster::class)->find($rosterId);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $roster) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            $this->em->remove($roster);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);
    }
}