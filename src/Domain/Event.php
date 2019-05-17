<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class Event
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="event")
 */
class Event implements JsonSerializable
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
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $name;

    /**
     * @var Roster[]
     *
     * @ORM\OneToMany(targetEntity="Participant", mappedBy="event", cascade={"persist", "remove"})
     */
    private $participants;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

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
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get roster
     *
     * @return Team[]
     */
    public function getParticipants(): array
    {
        return $this->participants;
    }

    /**
     * Set roster
     *
     * @param Team[] $participants
     *
     * @return self
     */
    public function setParticipants(array $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    /**
     * @param Team $participant
     *
     * @return self
     */
    public function addParticipant(Team $participant): self
    {
        if (false === $this->participants->contains($participant)) {
            $this->participants[] = $participant;
        }

        return $this;
    }

    /**
     * Set roster
     *
     * @param Team $participant
     *
     * @return self
     */
    public function removeParticipant(Team $participant): self
    {
        if ($this->participants->contains($participant)) {
            $this->participants->removeElement($participant);
        }

        return $this;
    }

    /**
     * @return array|mixed
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName()
        ];
    }
}