<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

#[Entity]
#[Table(name: "patient_visit_history")]
class PatientVisitHistory
{
    #[Id]
    #[GeneratedValue]
    #[Column(type: "integer")]
    private $id;

    #[Column(type: "integer")]
    private $patient_id;

    #[Column(type: "datetime")]
    private $visit_date;

    #[Column(type: "string", length: 255)]
    private $diagnosis;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPatientId()
    {
        return $this->patient_id;
    }

    public function setPatientId($patient_id): void
    {
        $this->patient_id = $patient_id;
    }

    public function getVisitDate()
    {
        return $this->visit_date;
    }

    public function setVisitDate($visit_date): void
    {
        $this->visit_date = $visit_date;
    }

    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    public function setDiagnosis($diagnosis): void
    {
        $this->diagnosis = $diagnosis;
    }
}