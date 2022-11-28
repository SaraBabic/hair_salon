<?php

namespace App\Entity;

use App\Repository\SalonWorkingHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalonWorkingHoursRepository::class)]
class SalonWorkingHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salonWorkingHours')]
    private ?Salon $salon = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingAt = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalon(): ?Salon
    {
        return $this->salon;
    }

    public function setSalon(?Salon $salon): self
    {
        $this->salon = $salon;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningAt(): ?\DateTimeInterface
    {
        return $this->openingAt;
    }

    public function setOpeningAt(\DateTimeInterface $openingAt): self
    {
        $this->openingAt = $openingAt;

        return $this;
    }

    public function getClosingAt(): ?\DateTimeInterface
    {
        return $this->closingAt;
    }

    public function setClosingAt(\DateTimeInterface $closingAt): self
    {
        $this->closingAt = $closingAt;

        return $this;
    }
}