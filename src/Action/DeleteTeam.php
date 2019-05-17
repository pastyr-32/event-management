<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Team;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class DeleteTeam
 * @package Nerdery\Action
 */
class DeleteTeam
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
            /** @var Team $team */
            $team = $this->em->getRepository(Team::class)->find($id);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $team) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            $this->em->remove($team);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);
    }
}