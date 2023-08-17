<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\ManyToMany(targetEntity: MovieCategory::class, inversedBy: 'movies')]
    private Collection $category;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $synopsis = null;

    #[ORM\ManyToMany(targetEntity: Actor::class, inversedBy: 'movies',cascade: ["persist"])]
    private Collection $casting;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $duration = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'movies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Director $director = null;

    #[ORM\Column]
    private ?bool $isNew = null;

    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->casting = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * @return Collection<int, MovieCategory>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(MovieCategory $category): static
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
        }

        return $this;
    }

    public function removeCategory(MovieCategory $category): static
    {
        $this->category->removeElement($category);

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getCasting(): Collection
    {
        return $this->casting;
    }

    public function addCasting(Actor $casting): static
    {
        if (!$this->casting->contains($casting)) {
            $this->casting->add($casting);
        }

        return $this;
    }

    public function removeCasting(Actor $casting): static
    {
        $this->casting->removeElement($casting);

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDirector(): ?Director
    {
        return $this->director;
    }

    public function setDirector(?Director $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function isIsNew(): ?bool
    {
        return $this->isNew;
    }

    public function setIsNew(bool $isNew): static
    {
        $this->isNew = $isNew;

        return $this;
    }

}
