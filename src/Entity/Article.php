<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['articles:read']],
    denormalizationContext: ['groups' => ['articles:write']],
)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['articles:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['articles:read', 'articles:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['articles:read', 'articles:write'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['articles:read', 'articles:write'])]
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

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
