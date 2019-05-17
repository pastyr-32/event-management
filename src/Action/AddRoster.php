<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Nerdery\Domain\Roster;
use Nerdery\Domain\Team;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class AddRoster
 * @package Nerdery\Action
 */
class AddRoster
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
        $userId = (int)$request->getParsedBodyParam('user_id');

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
            /** @var Roster $roster */
            $roster = new Roster;
            $roster->setUserId($userId);
            $roster->setTeam($team);

            $this->em->persist($roster);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($roster, StatusCode::HTTP_OK);
    }
}