<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Virus
 *
 * @ORM\Table(name="virus")
 * @ORM\Entity
 */
class Virus
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
     * @ORM\Column(name="id_inter", type="integer", length=60, nullable=true)
     */
    private $idInter;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_virus", type="string", length=60, nullable=true)
     */
    private $nomVirus;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=60, nullable=true)
     */
    private $description;

    /**
     * @var Solution
     *
     * @ORM\ManyToOne(targetEntity="Solution", inversedBy="idVirusSolution")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="solution", referencedColumnName="id")
     * })
     */
    private $Solution;

    /**
     * @return Solution
     */
    public function getSolution()
    {
        return $this->Solution;
    }

    /**
     * @param Solution $Solution
     * @return Virus
     */
    public function setSolution(Solution $Solution)
    {
        $this->Solution = $Solution;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Virus
     */
    public function setId(int $id)
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
     * @return Virus
     */
    public function setIdInter(int $idInter)
    {
        $this->idInter = $idInter;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomVirus(): ?string
    {
        return $this->nomVirus;
    }

    /**
     * @param string $nomVirus
     * @return Virus
     */
    public function setNomVirus(string $nomVirus)
    {
        $this->nomVirus = $nomVirus;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Virus
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

}