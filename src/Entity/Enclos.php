<?php

namespace App\Entity;

use App\Repository\EnclosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnclosRepository::class)]
class Enclos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbAnimaux = null;

    #[ORM\Column]
    private ?bool $quarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'oui')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espace $espace = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSuperficie(): ?int
    {
        return $this->superficie;
    }

    public function setSuperficie(int $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getNbAnimaux(): ?int
    {
        return $this->nbAnimaux;
    }

    public function setNbAnimaux(?int $nbAnimaux): self
    {
        $this->nbAnimaux = $nbAnimaux;

        return $this;
    }

    public function isQuarantaine(): ?bool
    {
        return $this->quarantaine;
    }

    public function setQuarantaine(bool $quarantaine): self
    {
        $this->quarantaine = $quarantaine;

        return $this;
    }

    public function getEspace(): ?Espace
    {
        return $this->espace;
    }

    public function setEspace(?Espace $espace): self
    {
        $this->espace = $espace;

        return $this;
    }
}
