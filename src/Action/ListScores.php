<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Event;
use Nerdery\Domain\Participant;
use Nerdery\Domain\Score;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class ListScores
 * @package Nerdery\Action
 */
class ListScores
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
            /** @var Score[] $scores */
            $scores = $this->em->getRepository(Score::class)->findBy(['participant' => $pid]);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withJson($scores, StatusCode::HTTP_OK);
    }
}