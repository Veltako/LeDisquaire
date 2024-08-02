<?php

namespace App\Entity;

use App\Repository\ChanteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChanteurRepository::class)]
class Chanteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Disque>
     */
    #[ORM\OneToMany(targetEntity: Disque::class, mappedBy: 'chanteur')]
    private Collection $disques;

    public function __construct()
    {
        $this->disques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Disque>
     */
    public function getDisques(): Collection
    {
        return $this->disques;
    }

    public function addDisque(Disque $disque): static
    {
        if (!$this->disques->contains($disque)) {
            $this->disques->add($disque);
            $disque->setChanteur($this);
        }

        return $this;
    }

    public function removeDisque(Disque $disque): static
    {
        if ($this->disques->removeElement($disque)) {
            // set the owning side to null (unless already changed)
            if ($disque->getChanteur() === $this) {
                $disque->setChanteur(null);
            }
        }

        return $this;
    }
}
