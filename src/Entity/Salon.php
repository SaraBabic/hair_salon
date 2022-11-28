<?php

namespace App\Entity;

use App\Repository\SalonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalonRepository::class)]
class Salon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\OneToOne(inversedBy: 'salon', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonRating::class)]
    private Collection $rating;

    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonWorkingHours::class)]
    private Collection $salonWorkingHours;

    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonServices::class)]
    private Collection $salonServices;

    public function __construct()
    {
        $this->rating = new ArrayCollection();
        $this->salonWorkingHours = new ArrayCollection();
        $this->salonServices = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getShortDescription():?string
    {
        return substr($this->description,0,100).'...';
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, SalonRating>
     */
    public function getSalonRatings(): Collection
    {
        return $this->rating;
    }

    public function addUser(SalonRating $rating): self
    {
        if (!$this->rating->contains($rating)) {
            $this->rating->add($rating);
            $rating->setSalon($this);
        }

        return $this;
    }

    public function removeUser(SalonRating $rating): self
    {
        if ($this->rating->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getSalon() === $this) {
                $rating->setSalon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SalonWorkingHours>
     */
    public function getSalonWorkingHours(): Collection
    {
        return $this->salonWorkingHours;
    }

    public function addSalonWorkingHour(SalonWorkingHours $salonWorkingHour): self
    {
        if (!$this->salonWorkingHours->contains($salonWorkingHour)) {
            $this->salonWorkingHours->add($salonWorkingHour);
            $salonWorkingHour->setSalon($this);
        }

        return $this;
    }

    public function removeSalonWorkingHour(SalonWorkingHours $salonWorkingHour): self
    {
        if ($this->salonWorkingHours->removeElement($salonWorkingHour)) {
            // set the owning side to null (unless already changed)
            if ($salonWorkingHour->getSalon() === $this) {
                $salonWorkingHour->setSalon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SalonServices>
     */
    public function getSalonServices(): Collection
    {
        return $this->salonServices;
    }

    public function addSalonService(SalonServices $salonService): self
    {
        if (!$this->salonServices->contains($salonService)) {
            $this->salonServices->add($salonService);
            $salonService->setSalon($this);
        }

        return $this;
    }

    public function removeSalonService(SalonServices $salonService): self
    {
        if ($this->salonServices->removeElement($salonService)) {
            // set the owning side to null (unless already changed)
            if ($salonService->getSalon() === $this) {
                $salonService->setSalon(null);
            }
        }

        return $this;
    }
}
