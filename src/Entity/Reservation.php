<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['reservation:write']]),
        new Put( denormalizationContext:  ['groups'=>['reservation:put']]),
        new Delete()
    ],
    class: User::class,
    normalizationContext: ['groups'=>['reservation:read']]
)]
#[ApiFilter(
    DateFilter::class, properties: ['startAt', 'endAt']
)]
#[ApiFilter(
    SearchFilter::class, properties: ['customer'=>'exact', 'hairdresser'=>'exact']
)]
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['reservation:read', 'reservation:write', 'reservation:put'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $startAt = null;

    #[Groups(['reservation:read','reservation:write', 'reservation:put'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $endAt = null;

    /**
     * @Assert\Valid()
     */
    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\ManyToOne(inversedBy: 'customerReservations')]
    private ?User $customer = null;

    /**
     * @Assert\Valid()
     */
    #[Groups(['reservation:read', 'reservation:write'])]
    #[ORM\ManyToOne(inversedBy: 'hairdresserReservations')]
    private ?User $hairdresser = null;

    /**
     * @Assert\Valid()
     */
    #[Groups(['reservation:read', 'reservation:write'])]
    #[SerializedName('services')]
    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: ReservationServices::class, cascade: ['persist', 'remove'])]
    private Collection $reservationServices;

    #[Groups(['reservation:read', 'reservation:write', 'reservation:put'])]
    #[ORM\Column(nullable: true)]
    private ?bool $canceled = false;

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

    public function getCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(?bool $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }

}
