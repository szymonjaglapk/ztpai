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

#[ApiResource]
#[Entity]
#[Table(name: "appointments")]
class Appointment
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private $id;

    #[ManyToOne(targetEntity: Doctor::class)]
    #[JoinColumn(name: "doctor_id", referencedColumnName: "id")]
    private $doctor;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: "user_id", referencedColumnName: "id", nullable: true)]
    private $user;

    #[Column(type: "datetime")]
    private $date;

    #[Column(type: "string", length: 255)]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctor(): ?Doctor
    {
        return $this->doctor;
    }

    public function setDoctor(?Doctor $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}