<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class Team
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="team")
 */
class Team implements JsonSerializable
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
     * @ORM\OneToMany(targetEntity="Roster", mappedBy="team", cascade={"persist", "remove"})
     */
    private $roster;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roster = new ArrayCollection();
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
     * @return Roster[]
     */
    public function getRoster(): array
    {
        return $this->roster;
    }

    /**
     * Set roster
     *
     * @param Roster[] $roster
     *
     * @return self
     */
    public function setRoster(array $roster): self
    {
        $this->roster = $roster;

        return $this;
    }

    /**
     * @param Roster $roster
     *
     * @return Team
     */
    public function addRoster(Roster $roster): self
    {
        if (false === $this->roster->contains($roster)) {
            $this->roster[] = $roster;
        }

        return $this;
    }

    /**
     * Set roster
     *
     * @param Roster $roster
     *
     * @return self
     */
    public function removeRoster(Roster $roster): self
    {
        if ($this->roster->contains($roster)) {
            $this->roster->removeElement($roster);
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