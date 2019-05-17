<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class Participant
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="event_participant")
 */
class Participant implements JsonSerializable
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
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="participants")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    private $event;

    /**
     * @var Team
     *
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="roster")
     * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
     */
    private $team;

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
     * Get event
     *
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * Set event
     *
     * @param Event $event
     *
     * @return self
     */
    public function setEvent(Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get team
     *
     * @return Team
     */
    public function getTeam(): Team
    {
        return $this->team;
    }

    /**
     * Set team
     *
     * @param Team $team
     *
     * @return self
     */
    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'event_id' => $this->getEvent()->getId(),
            'team_id' => $this->getTeam()->getId()
        ];
    }
}