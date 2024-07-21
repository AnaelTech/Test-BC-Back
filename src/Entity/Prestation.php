<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PrestationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read', 'orders:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prestations:read', 'prestations:write'])]
    private ?string $picture = null;

    #[ORM\Column(length: 255)]
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['prestations:read', 'prestations:write', 'articles:read', 'categories:read', 'orders:read'])]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'Prestation')]
    #[Groups(['prestations:read', 'prestations:write'])]
    private ?Category $category = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, mappedBy: 'prestations')]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }


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

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): static
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->addPrestation($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): static
    {
        if ($this->articles->removeElement($article)) {
            $article->removePrestation($this);
        }

        return $this;
    }
}
