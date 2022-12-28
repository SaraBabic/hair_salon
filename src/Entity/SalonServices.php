<?php

namespace App\Entity;

use App\Repository\SalonServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalonServicesRepository::class)]
class SalonServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'salonServices')]
    private ?Salon $salon = null;

    #[ORM\OneToMany(mappedBy: 'service', targetEntity: ReservationServices::class)]
    private Collection $reservationSalonServices;

    public function __construct()
    {
        $this->reservationSalonServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getServiceTimeAndPrice():string
    {
        return $this->duration . ' mins, ' . $this->price .' €';
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

    /**
     * @return Collection<int, ReservationServices>
     */
    public function getReservationSalonServices(): Collection
    {
        return $this->reservationSalonServices;
    }

    public function addReservationSalonService(ReservationServices $reservationSalonService): self
    {
        if (!$this->reservationSalonServices->contains($reservationSalonService)) {
            $this->reservationSalonServices->add($reservationSalonService);
            $reservationSalonService->setService($this);
        }

        return $this;
    }

    public function removeReservationSalonService(ReservationServices $reservationSalonService): self
    {
        if ($this->reservationSalonServices->removeElement($reservationSalonService)) {
            // set the owning side to null (unless already changed)
            if ($reservationSalonService->getService() === $this) {
                $reservationSalonService->setService(null);
            }
        }

        return $this;
    }

}
