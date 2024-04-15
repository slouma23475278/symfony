<?php

namespace App\Entity;

use App\Repository\LectureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LectureRepository::class)]
class Lecture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column (name: "IdLecture")]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'lecture', targetEntity: Evenement::class)]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $evenement->setLecture($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getLecture() === $this) {
                $evenement->setLecture(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getId();
    }
}
