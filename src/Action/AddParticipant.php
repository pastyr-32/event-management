<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Nerdery\Domain\Participant;
use Nerdery\Domain\Team;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class AddParticipant
 * @package Nerdery\Action
 */
class AddParticipant
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
        $tid = (int)$request->getParsedBodyParam('tid');

        try {
            /** @var Event $event */
            $event = $this->em->getRepository(Event::class)->find($id);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $event) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            /** @var Team $team */
            $team = $this->em->getRepository(Team::class)->find($tid);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $team) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            /** @var Participant $participant */
            $participant = new Participant;
            $participant->setEvent($event);
            $participant->setTeam($team);

            $this->em->persist($participant);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($participant, StatusCode::HTTP_OK);
    }
}