<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
#[ORM\Table(name: "clubs")]
class Club
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name : "IdClub")]
    private ?int $id = null;

    #[ORM\Column(name : "NomClub" , length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 5)]
    private ?string $NomClub = null;

    #[ORM\Column(name : "FonctionClub",length: 10)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 10)] 
    private ?string $FonctionClub = null;

    #[ORM\Column(name:"DescriptionClub", length: 10)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $DescriptionClub = null;

    #[ORM\Column(name:"LogoClub" , type: Types::BLOB )]
    private $LogoClub = null;

    #[ORM\Column (name:"TresorieClub") ]
    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\d+(\.\d{1,2})?$/',
        message: 'The value should be a positive number with up to 2 decimal places.'
    )]
    private ?float $TresorieClub = null;


    #[ORM\Column (name : "LocalClub")]
    #[Assert\NotBlank]
    private ?int $LocalClub = null;

    #[ORM\Column (name:"NombreStudentClub")]
    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual(
        value: 0,
        message: 'The value should be a positive number or zero.'
    )]
    private ?int $NombreStudentClub = null;

    #[ORM\OneToMany(mappedBy: 'club', targetEntity: Evenement::class)]
    #[ORM\JoinColumn(name: "IdEvent", referencedColumnName: "IdEvent")]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Evenement>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setClub($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getClub() === $this) {
                $evenement->setClub(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNomClub();
    }
}
