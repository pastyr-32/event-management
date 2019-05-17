<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class Score
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="participant_score")
 */
class Score implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Participant
     *
     * @ORM\OneToOne(targetEntity="Participant")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id")
     */
    private $participant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    private $score;

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get participant
     *
     * @return Participant
     */
    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    /**
     * Set participant
     *
     * @param Participant $participant
     *
     * @return self
     */
    public function setParticipant(Participant $participant): self
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * Get score
     *
     * @return string
     */
    public function getScore(): string
    {
        return $this->score;
    }

    /**
     * Set score
     *
     * @param string $score
     *
     * @return self
     */
    public function setScore(string $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'participant_id' => $this->getParticipant()->getId(),
            'score' => $this->getScore()
        ];
    }
}