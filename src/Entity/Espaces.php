<?php

namespace App\Entity;

use App\Repository\EspacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EspacesRepository::class)]
class Espaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $superficie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_ouverture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fermeture = null;

    #[ORM\OneToMany(mappedBy: 'espces_id', targetEntity: Enclos::class)]
    private Collection $nom_enclo;

    public function __construct()
    {
        $this->nom_enclo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
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

    public function getDateOuverture(): ?\DateTimeInterface
    {
        return $this->date_ouverture;
    }

    public function setDateOuverture(?\DateTimeInterface $date_ouverture): self
    {
        $this->date_ouverture = $date_ouverture;

        return $this;
    }

    public function getDateFermeture(): ?\DateTimeInterface
    {
        return $this->date_fermeture;
    }

    public function setDateFermeture(?\DateTimeInterface $date_fermeture): self
    {
        $this->date_fermeture = $date_fermeture;

        return $this;
    }

    /**
     * @return Collection<int, Enclos>
     */
    public function getNomEnclo(): Collection
    {
        return $this->nom_enclo;
    }

    public function addNomEnclo(Enclos $nomEnclo): self
    {
        if (!$this->nom_enclo->contains($nomEnclo)) {
            $this->nom_enclo->add($nomEnclo);
            $nomEnclo->setEspcesId($this);
        }

        return $this;
    }

    public function removeNomEnclo(Enclos $nomEnclo): self
    {
        if ($this->nom_enclo->removeElement($nomEnclo)) {
            // set the owning side to null (unless already changed)
            if ($nomEnclo->getEspcesId() === $this) {
                $nomEnclo->setEspcesId(null);
            }
        }

        return $this;
    }
}
