<?php

namespace App\Entity;

use App\Repository\TheaterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TheaterRepository::class)]
class Theater
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $zipCode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $city = null;

    #[ORM\OneToMany(mappedBy: 'theater', targetEntity: MovieSession::class, orphanRemoval: true)]
    private Collection $movieSession;

    public function __construct()
    {
        $this->movieSession = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return Collection<int, MovieSession>
     */
    public function getMovieSession(): Collection
    {
        return $this->movieSession;
    }

    public function addMovieSession(MovieSession $movieSession): static
    {
        if (!$this->movieSession->contains($movieSession)) {
            $this->movieSession->add($movieSession);
            $movieSession->setTheater($this);
        }

        return $this;
    }

    public function removeMovieSession(MovieSession $movieSession): static
    {
        if ($this->movieSession->removeElement($movieSession)) {
            // set the owning side to null (unless already changed)
            if ($movieSession->getTheater() === $this) {
                $movieSession->setTheater(null);
            }
        }

        return $this;
    }
}
