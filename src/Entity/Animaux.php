<?php

namespace App\Entity;

use App\Repository\AnimauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimauxRepository::class)]
class Animaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $numero_identification = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_arrivee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_depart = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $proprietaire = null;

    #[ORM\Column(length: 50)]
    private ?string $genre = null;

    #[ORM\Column(length: 50)]
    private ?string $espece = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $sterilise = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $quarantaine = null;

    #[ORM\ManyToMany(targetEntity: enclos::class, inversedBy: 'animaux_id')]
    private Collection $animauxparenclos;

    public function __construct()
    {
        $this->animauxparenclos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroIdentification(): ?string
    {
        return $this->numero_identification;
    }

    public function setNumeroIdentification(string $numero_identification): self
    {
        $this->numero_identification = $numero_identification;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->date_arrivee;
    }

    public function setDateArrivee(\DateTimeInterface $date_arrivee): self
    {
        $this->date_arrivee = $date_arrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(?\DateTimeInterface $date_depart): self
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getProprietaire(): ?int
    {
        return $this->proprietaire;
    }

    public function setProprietaire(int $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getEspece(): ?string
    {
        return $this->espece;
    }

    public function setEspece(string $espece): self
    {
        $this->espece = $espece;

        return $this;
    }

    public function getSterilise(): ?int
    {
        return $this->sterilise;
    }

    public function setSterilise(?int $sterilise): self
    {
        $this->sterilise = $sterilise;

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
     * @return Collection<int, enclos>
     */
    public function getAnimauxparenclos(): Collection
    {
        return $this->animauxparenclos;
    }

    public function addAnimauxparenclo(enclos $animauxparenclo): self
    {
        if (!$this->animauxparenclos->contains($animauxparenclo)) {
            $this->animauxparenclos->add($animauxparenclo);
        }

        return $this;
    }

    public function removeAnimauxparenclo(enclos $animauxparenclo): self
    {
        $this->animauxparenclos->removeElement($animauxparenclo);

        return $this;
    }
}
