<?php

namespace App\Entity;

use App\Repository\ReservationServicesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationServicesRepository::class)]
class ReservationServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservationServices')]
    private ?Reservation $reservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservationSalonServices')]
    private ?SalonServices $service = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getService(): ?SalonServices
    {
        return $this->service;
    }

    public function setService(?SalonServices $service): self
    {
        $this->service = $service;

        return $this;
    }
}
