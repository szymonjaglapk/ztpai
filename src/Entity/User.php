<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use DateTime;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\OneToOne;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;


#[Entity]
#[Table(name: "users")]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[GeneratedValue(strategy: "IDENTITY")]
    #[Column(type: "integer")]
    private int $id;

    #[Column(type: "string", length: 180, unique: true)]
    private string $email;

    #[Column(type: "string")]
    private string $password;

    #[Column(type: "boolean")]
    private bool $enabled;

    #[Column(type: "datetime")]
    private DateTime $created_at;

    #[OneToOne(targetEntity: UserDetails::class, mappedBy: "user", cascade: ["persist", "remove"])]
    private UserDetails $userDetails;

    #[Column(type: "json")]
    private array $roles = [];

    public function __construct()
    {
        $this->roles = ['ROLE_USER_OUT'];
        $this->password = '';
        $this->enabled = true;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getEnabled() :bool
    {
        return $this->enabled;
    }

    public function setEnabled($enabled): void
    {
        $this->enabled = $enabled;
    }


    public function getCreatedAt(): DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }
    public function getUserDetails(): UserDetails
    {
        return $this->userDetails;
    }
    public function eraseCredentials(): void
    {

    }
    public function getName(): string
    {
        return $this->getUserDetails()->getName();
    }

    public function getSurname(): string
    {
        return $this->getUserDetails()->getSurname();
    }

    public function getPhone(): string
    {
        return $this->getUserDetails()->getPhone();
    }
}