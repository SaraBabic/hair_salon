<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ReservationServicesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['reservationServices:write']]),
        new Delete()
    ],
    class: User::class,
    normalizationContext: ['groups'=>['reservationServices:read']]
)]
#[ORM\Entity(repositoryClass: ReservationServicesRepository::class)]
class ReservationServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['reservationServices:read', 'reservationServices:write'])]
    #[ORM\ManyToOne(inversedBy: 'reservationServices')]
    private ?Reservation $reservation = null;

    #[Groups([
        'reservation:read',
        'reservationServices:read', 'reservationServices:write'
    ])]
    #[SerializedName('salonService')]
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
