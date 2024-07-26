<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    normalizationContext: ['groups' => ['orders:read']],
    denormalizationContext: ['groups' => ['orders:write']],
)]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['orders:read', 'users:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    #[Groups(['orders:read', 'orders:write', 'users:read'])]
    private ?array $statut = null;

    #[ORM\Column]
    #[Groups(['orders:read', 'orders:write', 'users:read'])]
    private ?int $total = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[Groups(['orders:read', 'orders:write'])]
    private ?User $client = null;

    /**
     * @var Collection<int, Article>
     */
    #[ORM\ManyToMany(targetEntity: Article::class, inversedBy: 'orders')]
    #[Groups(['users:read', 'orders:read', 'orders:write'])]
    private Collection $article_commande;

    #[ORM\ManyToOne(inversedBy: 'employee_orders')]
    #[Groups(['orders:read', 'orders:write'])]
    private ?User $employee = null;

    public function __construct()
    {
        $this->article_commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?array
    {
        return $this->statut;
    }

    public function setStatut(?array $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticleCommande(): Collection
    {
        return $this->article_commande;
    }

    public function addArticleCommande(Article $articleCommande): static
    {
        if (!$this->article_commande->contains($articleCommande)) {
            $this->article_commande->add($articleCommande);
        }

        return $this;
    }

    public function removeArticleCommande(Article $articleCommande): static
    {
        $this->article_commande->removeElement($articleCommande);

        return $this;
    }

    public function getEmployee(): ?User
    {
        return $this->employee;
    }

    public function setEmployee(?User $employee): static
    {
        $this->employee = $employee;

        return $this;
    }
}
