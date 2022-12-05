<?php

namespace App\Entity;

use App\Repository\EnclosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnclosRepository::class)]
class Enclos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'nom_enclo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?espaces $espces_id = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column]
    private ?int $animaux_max = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quarantaine = null;

    #[ORM\ManyToMany(targetEntity: Animaux::class, mappedBy: 'animauxparenclos')]
    private Collection $animaux_id;

    public function __construct()
    {
        $this->animaux_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEspcesId(): ?espaces
    {
        return $this->espces_id;
    }

    public function setEspcesId(?espaces $espces_id): self
    {
        $this->espces_id = $espces_id;

        return $this;
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
        return $this->animaux_max;
    }

    public function setAnimauxMax(int $animaux_max): self
    {
        $this->animaux_max = $animaux_max;

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

    /**
     * @return Collection<int, Animaux>
     */
    public function getAnimauxId(): Collection
    {
        return $this->animaux_id;
    }

    public function addAnimauxId(Animaux $animauxId): self
    {
        if (!$this->animaux_id->contains($animauxId)) {
            $this->animaux_id->add($animauxId);
            $animauxId->addAnimauxparenclo($this);
        }

        return $this;
    }

    public function removeAnimauxId(Animaux $animauxId): self
    {
        if ($this->animaux_id->removeElement($animauxId)) {
            $animauxId->removeAnimauxparenclo($this);
        }

        return $this;
    }
}
