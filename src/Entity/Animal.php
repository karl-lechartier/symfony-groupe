<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 14)]
    private ?string $numeroIdentification = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateArrivee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateDepart = null;

    #[ORM\Column]
    private ?bool $zooEstProprietaire = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column(length: 255)]
    private ?string $espece = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(nullable: true)]
    private ?bool $sterile = null;

    #[ORM\Column]
    private ?bool $enQuarantaine = null;

    #[ORM\ManyToOne(inversedBy: 'animaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enclo $encloID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroIdentification(): ?string
    {
        return $this->numeroIdentification;
    }

    public function setNumeroIdentification(string $numeroIdentification): self
    {
        $this->numeroIdentification = $numeroIdentification;

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
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDateArrivee(): ?\DateTimeInterface
    {
        return $this->dateArrivee;
    }

    public function setDateArrivee(\DateTimeInterface $dateArrivee): self
    {
        $this->dateArrivee = $dateArrivee;

        return $this;
    }

    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->dateDepart;
    }

    public function setDateDepart(?\DateTimeInterface $dateDepart): self
    {
        $this->dateDepart = $dateDepart;

        return $this;
    }

    public function isZooEstProprietaire(): ?bool
    {
        return $this->zooEstProprietaire;
    }

    public function setZooEstProprietaire(bool $zooEstProprietaire): self
    {
        $this->zooEstProprietaire = $zooEstProprietaire;

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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function isSterile(): ?bool
    {
        return $this->sterile;
    }

    public function setSterile(?bool $sterile): self
    {
        $this->sterile = $sterile;

        return $this;
    }

    public function isEnQuarantaine(): ?bool
    {
        return $this->enQuarantaine;
    }

    public function setEnQuarantaine(bool $enQuarantaine): self
    {
        $this->enQuarantaine = $enQuarantaine;

        return $this;
    }

    public function getEncloID(): ?Enclo
    {
        return $this->encloID;
    }

    public function setEncloID(?Enclo $encloID): self
    {
        $this->encloID = $encloID;

        return $this;
    }
}
