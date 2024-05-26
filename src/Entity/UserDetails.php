<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: "user_details")]
#[ApiResource]
class UserDetails
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private int $id;
    #[OneToOne(targetEntity: User::class, inversedBy: "userDetails")]
    #[JoinColumn(name: "user_id", referencedColumnName: "id")]
    private User $user;

    #[Column(type: "string", length: 255)]
    private $name;

    #[Column(type: "string", length: 255)]
    private $surname;

    #[Column(type: "string", length: 255)]
    private $phone;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user= $user;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }
    public function getId(): int
    {
        return $this->getUser()->getId();
    }
}