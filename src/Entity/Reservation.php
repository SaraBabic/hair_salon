<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'customerReservations')]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'hairdresserReservations')]
    private ?User $hairdresser = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: ReservationServices::class)]
    private Collection $reservationServices;

    public function __construct()
    {
        $this->reservationServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getHairdresser(): ?User
    {
        return $this->hairdresser;
    }

    public function setHairdresser(?User $hairdresser): self
    {
        $this->hairdresser = $hairdresser;

        return $this;
    }

    /**
     * @return Collection<int, ReservationServices>
     */
    public function getReservationServices(): Collection
    {
        return $this->reservationServices;
    }

    public function addReservationService(ReservationServices $reservationService): self
    {
        if (!$this->reservationServices->contains($reservationService)) {
            $this->reservationServices->add($reservationService);
            $reservationService->setReservation($this);
        }

        return $this;
    }

    public function removeReservationService(ReservationServices $reservationService): self
    {
        if ($this->reservationServices->removeElement($reservationService)) {
            // set the owning side to null (unless already changed)
            if ($reservationService->getReservation() === $this) {
                $reservationService->setReservation(null);
            }
        }

        return $this;
    }

}
