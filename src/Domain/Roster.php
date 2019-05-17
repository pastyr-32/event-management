<?php
declare(strict_types=1);

namespace Nerdery\Domain;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * Class Roster
 * @package Nerdery\Domain
 *
 * @ORM\Entity()
 * @ORM\Table(name="team_roster")
 */
class Roster implements JsonSerializable
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
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false, name="user_id")
     */
    private $userId;

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
     * Get userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set userId
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

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
            'team_id' => $this->getTeam()->getId(),
            'user_id' => $this->getUserId()
        ];
    }
}