<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: "appointments")]
class Appointment
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private $id;

    #[Column(type: "integer")]
    private $doctor_id;

    #[Column(type: "integer", nullable: true)]
    private $patient_id;

    #[Column(type: "datetime")]
    private $date;

    #[Column(type: "string", length: 255)]
    private $status;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getDoctorId()
    {
        return $this->doctor_id;
    }

    public function setDoctorId($doctor_id): void
    {
        $this->doctor_id = $doctor_id;
    }

    public function getPatientId()
    {
        return $this->patient_id;
    }

    public function setPatientId($patient_id): void
    {
        $this->patient_id = $patient_id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }
}