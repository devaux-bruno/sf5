<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Interruptions
 *
 * @ORM\Table(name="interruptions")
 * @ORM\Entity(repositoryClass="App\Repository\InterruptionsRepository")
 */
class Interruptions
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="identifiant du timer sur cg"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stamp_maj", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $stampMaj = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="id_virus", type="text", length=32, nullable=false, options={"comment"="transport affecte"})
     */
    private $transport;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="text", nullable=false, options={"comment"="type d intervention : 0 intervention programme 1 incident down 2 incident ralenti"})
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true, options={"comment"="description destin au support de l'interruption"})
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="stamp_begin", type="datetime", nullable=false, options={"unsigned"=true,"comment"="date de debut de l incident"})
     */
    private $stampBegin;

    /**
     * @var int
     *
     * @ORM\Column(name="stamp_end", type="datetime", nullable=false, options={"comment"="date de fin de l incident"})
     */
    private $stampEnd;

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1","comment"="activité du tuple 0 inactif 1 actif"})
     */
    private $active = '1';

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Interruptions
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStampMaj()
    {
        return $this->stampMaj;
    }

    /**
     * @param \DateTime $stampMaj
     * @return Interruptions
     */
    public function setStampMaj(\DateTime $stampMaj)
    {
        $this->stampMaj = $stampMaj;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransport(): ?string
    {
        return $this->transport;
    }

    /**
     * @param string $transport
     * @return Interruptions
     */
    public function setTransport(string $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Interruptions
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return Interruptions
     */
    public function setDescription(?string $description): Interruptions
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStampBegin()
    {
        return $this->stampBegin;
    }

    /**
     * @param DateTime $stampBegin
     * @return Interruptions
     */
    public function setStampBegin( $stampBegin)
    {
        $this->stampBegin = $stampBegin;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStampEnd()
    {
        return $this->stampEnd;
    }

    /**
     * @param DateTime $stampEnd
     * @return Interruptions
     */
    public function setStampEnd($stampEnd)
    {
        $this->stampEnd = $stampEnd;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return Interruptions
     */
    public function setActive(bool $active)
    {
        $this->active = $active;
        return $this;
    }


}
