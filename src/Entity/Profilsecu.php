<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProfilsecuController
 *
 * @ORM\Table(name="profilsecu")
 * @ORM\Entity
 */
class Profilsecu implements UserInterface
{

    public function getRoles() : array
    {
        if($this->getStatut() == '1'){
            return [
                'ROLE_ADMIN'
            ];
        }
        else{
            return [
                'ROLE_MEMBER'
            ];
        }
    }


    /*
     * la fonction password permet de retourner le mdp de la bdd
     */
    public function getPassword() :?string
    {
        return $this->passwordsecu;
    }


    public function getSalt()
    {
        return null;
    }


    /*
     * retour l'adresse mail de la bdd
     */
    public function getUsername() :?string
    {
        return $this->usernames;
    }


    /*
     * permet d'éviter les donnée sensible comme les mdp
     */
    public function eraseCredentials()
    {

    }
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=60, nullable=false)
     */
    private $usernames;

    /**
     * @var string
     *
     * @ORM\Column(name="passwordsecu", type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message = "Veillez renseigner un mot de passe")
     */
    private $passwordsecu;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=60, nullable=false)
     */
    private $statut;

    /**
     * @var int
     *
     * @ORM\Column(name="imageprofil", type="string", nullable=false)
     */
    private $imageprofil;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsernames(): ?string
    {
        return $this->usernames;
    }

    /**
     * @param string $usernames
     * @return Profilsecu
     */
    public function setUsernames(string $usernames): Profilsecu
    {
        $this->usernames = $usernames;
        return $this;
    }

    /**
     * @param int $id
     * @return Profilsecu
     */
    public function setId(int $id): Profilsecu
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordsecu(): ?string
    {
        return $this->passwordsecu;
    }

    /**
     * @param string $passwordsecu
     * @return Profilsecu
     */
    public function setPasswordsecu(string $passwordsecu): Profilsecu
    {
        $this->passwordsecu = $passwordsecu;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatut(): ?string
    {
        return $this->statut;
    }

    /**
     * @param string $statut
     * @return Profilsecu
     */
    public function setStatut(string $statut): Profilsecu
    {
        $this->statut = $statut;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageprofil(): ?string
    {
        return $this->imageprofil;
    }

    /**
     * @param string $imageprofil
     * @return Profilsecu
     */
    public function setImageprofil(string $imageprofil): Profilsecu
    {
        $this->imageprofil = $imageprofil;
        return $this;
    }


}
