<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $NomClub = null;

    #[ORM\Column(length: 10)]
    private ?string $FonctionClub = null;

    #[ORM\Column(length: 10)]
    private ?string $DescriptionClub = null;

    #[ORM\Column(type: Types::BLOB)]
    private $LogoClub = null;

    #[ORM\Column]
    private ?float $TresorieClub = null;

    #[ORM\Column]
    private ?int $LocalClub = null;

    #[ORM\Column]
    private ?int $NombreStudentClub = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClub(): ?string
    {
        return $this->NomClub;
    }

    public function setNomClub(string $NomClub): static
    {
        $this->NomClub = $NomClub;

        return $this;
    }

    public function getFonctionClub(): ?string
    {
        return $this->FonctionClub;
    }

    public function setFonctionClub(string $FonctionClub): static
    {
        $this->FonctionClub = $FonctionClub;

        return $this;
    }

    public function getDescriptionClub(): ?string
    {
        return $this->DescriptionClub;
    }

    public function setDescriptionClub(string $DescriptionClub): static
    {
        $this->DescriptionClub = $DescriptionClub;

        return $this;
    }

    public function getLogoClub()
    {
        return $this->LogoClub;
    }

    public function setLogoClub($LogoClub): static
    {
        $this->LogoClub = $LogoClub;

        return $this;
    }

    public function getTresorieClub(): ?float
    {
        return $this->TresorieClub;
    }

    public function setTresorieClub(float $TresorieClub): static
    {
        $this->TresorieClub = $TresorieClub;

        return $this;
    }

    public function getLocalClub(): ?int
    {
        return $this->LocalClub;
    }

    public function setLocalClub(int $LocalClub): static
    {
        $this->LocalClub = $LocalClub;

        return $this;
    }

    public function getNombreStudentClub(): ?int
    {
        return $this->NombreStudentClub;
    }

    public function setNombreStudentClub(int $NombreStudentClub): static
    {
        $this->NombreStudentClub = $NombreStudentClub;

        return $this;
    }
}
