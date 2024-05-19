<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[Entity]
#[Table(name: "doctors")]
#[ApiResource]
class Doctor
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: "user_id", referencedColumnName: "id")]
    private $user;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
    public function getUserDetails(): UserDetails
    {
        return $this->getUser()->getUserDetails();
    }
}