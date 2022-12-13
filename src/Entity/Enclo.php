<?php

namespace App\Entity;

use App\Repository\EncloRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EncloRepository::class)]
class Enclo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column]
    private ?int $animauxMax = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'enclos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Espace $espaceID = null;

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

    public function getAnimauxMax(): ?int
    {
        return $this->animauxMax;
    }

    public function setAnimauxMax(int $animauxMax): self
    {
        $this->animauxMax = $animauxMax;

        return $this;
    }

    public function getQuarantaine(): ?int
    {
        return $this->quarantaine;
    }

    public function setQuarantaine(int $quarantaine): self
    {
        $this->quarantaine = $quarantaine;

        return $this;
    }

    public function getEspaceID(): ?Espace
    {
        return $this->espaceID;
    }

    public function setEspaceID(?Espace $espaceID): self
    {
        $this->espaceID = $espaceID;

        return $this;
    }
}
