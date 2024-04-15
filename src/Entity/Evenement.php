<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "IdEvent", type: "integer", nullable: true)]
    private ?int $id = null;

    #[ORM\Column(name: "TypeEvent", length: 255)]
    private ?string $typeEvenement = null;

    #[ORM\Column(name: "NomEvent", length: 255)]
    private ?string $nomEvenement = null;

    #[ORM\Column(name: "Description", length: 255)]
    private ?string $descriptionEvenement = null;

    #[ORM\Column(name: "TimeEventD", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeEventDebut = null;

    #[ORM\Column(name: "TimeEventF", type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timeEventFin = null;

    #[ORM\Column(name: "LienFichier", length: 255)]
    private ?string $lienFichier = null;

    #[ORM\Column(name: "DateEvent", length: 255)]
    private ?string $destinationEvenement = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(name: "IdClub", referencedColumnName: "IdClub")]
    private ?Club $club = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(name: "IdLecture", referencedColumnName: "IdLecture")]
    private ?Lecture $lecture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(string $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    public function getNomEvenement(): ?string
    {
        return $this->nomEvenement;
    }

    public function setNomEvenement(string $nomEvenement): static
    {
        $this->nomEvenement = $nomEvenement;

        return $this;
    }

    public function getDescriptionEvenement(): ?string
    {
        return $this->descriptionEvenement;
    }

    public function setDescriptionEvenement(string $descriptionEvenement): static
    {
        $this->descriptionEvenement = $descriptionEvenement;

        return $this;
    }

    public function getTimeEventDebut(): ?\DateTimeInterface
    {
        return $this->timeEventDebut;
    }

    public function setTimeEventDebut(\DateTimeInterface $timeEventDebut): static
    {
        $this->timeEventDebut = $timeEventDebut;

        return $this;
    }

    public function getTimeEventFin(): ?\DateTimeInterface
    {
        return $this->timeEventFin;
    }

    public function setTimeEventFin(\DateTimeInterface $timeEventFin): static
    {
        $this->timeEventFin = $timeEventFin;

        return $this;
    }

    public function getLienFichier(): ?string
    {
        return $this->lienFichier;
    }

    public function setLienFichier(string $lienFichier): static
    {
        $this->lienFichier = $lienFichier;

        return $this;
    }

    public function getDestinationEvenement(): ?string
    {
        return $this->destinationEvenement;
    }

    public function setDestinationEvenement(string $destinationEvenement): static
    {
        $this->destinationEvenement = $destinationEvenement;

        return $this;
    }

    public function getClub(): ?club
    {
        return $this->club;
    }

    public function setClub(?club $club): static
    {
        $this->club = $club;

        return $this;
    }

    public function getLecture(): ?lecture
    {
        return $this->lecture;
    }

    public function setLecture(?lecture $lecture): static
    {
        $this->lecture = $lecture;

        return $this;
    }
}
