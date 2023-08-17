<?php

namespace App\Entity;

use App\Repository\MovieSessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieSessionRepository::class)]
class MovieSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column]
    private ?int $room = null;

    #[ORM\Column]
    private ?int $beginningHour = null;

    #[ORM\Column]
    private ?int $beginningMinute = null;

    #[ORM\ManyToOne(inversedBy: 'movieSession')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Theater $theater = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): static
    {
        $this->room = $room;

        return $this;
    }

    public function getBeginningHour(): ?int
    {
        return $this->beginningHour;
    }

    public function setBeginningHour(int $beginningHour): static
    {
        $this->beginningHour = $beginningHour;

        return $this;
    }

    public function getBeginningMinute(): ?int
    {
        return $this->beginningMinute;
    }

    public function setBeginningMinute(int $beginningMinute): static
    {
        $this->beginningMinute = $beginningMinute;

        return $this;
    }

    public function getTheater(): ?Theater
    {
        return $this->theater;
    }

    public function setTheater(?Theater $theater): static
    {
        $this->theater = $theater;

        return $this;
    }
}
