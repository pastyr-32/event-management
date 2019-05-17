<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Nerdery\Domain\Participant;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class RemoveParticipant
 * @package Nerdery\Action
 */
class RemoveParticipant
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
        $pid = (int)$request->getAttribute('pid');

        try {
            /** @var Participant $participant */
            $participant = $this->em->getRepository(Participant::class)->find($pid);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $participant) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            $this->em->remove($participant);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);
    }
}