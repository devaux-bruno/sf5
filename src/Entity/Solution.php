<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Solution
 *
 * @ORM\Table(name="solution")
 * @ORM\Entity
 */
class Solution
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="id_inter", type="integer", nullable=false)
     */
    private $idInter;

    /**
     * @var string
     *
     * @ORM\Column(name="solutions", type="text", length=65535, nullable=false)
     */
    private $solutions;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Solution
     */
    public function setId(int $id): Solution
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdInter(): ?int
    {
        return $this->idInter;
    }

    /**
     * @param int $idInter
     * @return Solution
     */
    public function setIdInter(int $idInter): Solution
    {
        $this->idInter = $idInter;
        return $this;
    }

    /**
     * @return string
     */
    public function getSolutions(): ?string
    {
        return $this->solutions;
    }

    /**
     * @param string $solutions
     * @return Solution
     */
    public function setSolutions(string $solutions): Solution
    {
        $this->solutions = $solutions;
        return $this;
    }


}
