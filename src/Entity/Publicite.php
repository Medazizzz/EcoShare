<?php

namespace App\Entity;

use App\Repository\PubliciteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PubliciteRepository::class)]
class Publicite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url]
    private ?string $lien = null;

    #[ORM\ManyToOne(inversedBy: 'publicites')]
    private ?SponsorPartenaire $sponsorPartenaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): self
    {
        $this->lien = $lien;

        return $this;
    }

    public function getSponsorPartenaire(): ?SponsorPartenaire
    {
        return $this->sponsorPartenaire;
    }

    public function setSponsorPartenaire(?SponsorPartenaire $sponsorPartenaire): self
    {
        $this->sponsorPartenaire = $sponsorPartenaire;

        return $this;
    }
}
