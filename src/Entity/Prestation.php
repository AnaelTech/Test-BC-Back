<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PrestationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PrestationRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['prestations:read']],
    denormalizationContext: ['groups' => ['prestations:write']],
)]
class Prestation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['prestations:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prestations:read', 'prestations:write'])]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'Prestation')]
    #[Groups(['prestations:read', 'prestations:write'])]
    private ?Category $category = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
