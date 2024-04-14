<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: "users")]
class User
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private $id;

    #[Column(type: "string", length: 180, unique: true)]
    private $email;

    #[Column(type: "string")]
    private $password;

    #[Column(type: "boolean")]
    private $enabled;

    #[Column(type: "string", nullable: true)]
    private $salt;

    #[Column(type: "datetime")]
    private $created_at;

    #[Column(type: "integer")]
    private $id_user_details;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt): void
    {
        $this->salt = $salt;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getIdUserDetails()
    {
        return $this->id_user_details;
    }

    public function setIdUserDetails($id_user_details): void
    {
        $this->id_user_details = $id_user_details;
    }
}