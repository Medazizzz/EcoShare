<?php

namespace App\Entity;

use App\Enum\TypeEvenement;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\SponsorPartenaire;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual('now', message: 'La date de l\'événement ne peut pas être antérieure à la date actuelle.')]
    private ?\DateTime $dateEvent = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(enumType: TypeEvenement::class)]
    private ?TypeEvenement $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $organisateurNom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $organisateurPrenom = null;

    
    #[ORM\ManyToMany(targetEntity: SponsorPartenaire::class, inversedBy: 'evenements')]
    #[ORM\JoinTable(name: 'evenement_sponsor_partenaire')]
    private Collection $sponsorsPartenaires;

/**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'evenement', orphanRemoval: true)]
    private Collection $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->sponsorsPartenaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateEvent(): ?\DateTime
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTime $dateEvent): static
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getType(): ?TypeEvenement
    {
        return $this->type;
    }

    public function setType(TypeEvenement $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getOrganisateurNom(): ?string
    {
        return $this->organisateurNom;
    }

    public function setOrganisateurNom(?string $organisateurNom): static
    {
        $this->organisateurNom = $organisateurNom;

        return $this;
    }

    public function getOrganisateurPrenom(): ?string
    {
        return $this->organisateurPrenom;
    }

    public function setOrganisateurPrenom(?string $organisateurPrenom): static
    {
        $this->organisateurPrenom = $organisateurPrenom;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setEvenement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEvenement() === $this) {
                $commentaire->setEvenement(null);
            }
        }

        return $this;
    }
    /**
     * @return Collection<int, SponsorPartenaire>
     */
    public function getSponsorsPartenaires(): Collection
    {
        return $this->sponsorsPartenaires;
    }

    public function addSponsorsPartenaire(SponsorPartenaire $sponsorPartenaire): self
    {
        if (!$this->sponsorsPartenaires->contains($sponsorPartenaire)) {
            $this->sponsorsPartenaires->add($sponsorPartenaire);
        }

        return $this;
    }

    public function removeSponsorsPartenaire(SponsorPartenaire $sponsorPartenaire): self
    {
        $this->sponsorsPartenaires->removeElement($sponsorPartenaire);

        return $this;
    }

}
