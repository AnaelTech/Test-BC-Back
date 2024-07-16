<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['categories:read', 'articles:read']],
    denormalizationContext: ['groups' => ['categories:write']],
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['categories:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['categories:read', 'categories:write', 'articles:read'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'children')]
    #[ORM\JoinColumn(onDelete: "CASCADE")]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    #[Groups(['categories:read', 'categories:write'])]
    private Collection $children;

    /**
     * @var Collection<int, Prestation>
     */
    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Prestation::class, cascade: ['persist', 'remove'])]
    #[Groups(['categories:read', 'categories:write', 'articles:read'])]
    private Collection $Prestation;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->Prestation = new ArrayCollection();
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

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Prestation>
     */
    public function getPrestation(): Collection
    {
        return $this->Prestation;
    }

    public function addPrestation(Prestation $prestation): static
    {
        if (!$this->Prestation->contains($prestation)) {
            $this->Prestation->add($prestation);
            $prestation->setCategory($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): static
    {
        if ($this->Prestation->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getCategory() === $this) {
                $prestation->setCategory(null);
            }
        }

        return $this;
    }
}
