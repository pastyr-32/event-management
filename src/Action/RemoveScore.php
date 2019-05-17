<?php
declare(strict_types=1);

namespace Nerdery\Action;

use Doctrine\ORM\EntityManager;
use Nerdery\Domain\Score;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class RemoveScore
 * @package Nerdery\Action
 */
class RemoveScore
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
        $sid = (int)$request->getAttribute('sid');

        try {
            /** @var Score $score */
            $score = $this->em->getRepository(Score::class)->find($sid);
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (null === $score) {
            return $response->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }

        try {
            $this->em->remove($score);
            $this->em->flush();
        } catch (\Exception $e) {
            return $response->withStatus(StatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $response->withStatus(StatusCode::HTTP_NO_CONTENT);
    }
}