<?php

namespace App\Entity;

use App\Repository\DisqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DisqueRepository::class)]
class Disque
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:2, max:2)]
    private ?string $nomDisque = null;

    #[ORM\ManyToOne(inversedBy: 'disques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Chanteur $chanteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDisque(): ?string
    {
        return $this->nomDisque;
    }

    public function setNomDisque(string $nomDisque): static
    {
        $this->nomDisque = $nomDisque;

        return $this;
    }

    public function getChanteur(): ?Chanteur
    {
        return $this->chanteur;
    }

    public function setChanteur(?Chanteur $chanteur): static
    {
        $this->chanteur = $chanteur;

        return $this;
    }
}
