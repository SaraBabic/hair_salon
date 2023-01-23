<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SalonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['salon:write']]),
        new Put( denormalizationContext: ['groups'=>['salon:put']]),
        new Delete()
    ],
    class: Salon::class,
    normalizationContext: ['groups'=>['salon:read']]
)]
#[ApiFilter(
    BooleanFilter::class, properties: ['isActive']
)]
#[ApiFilter(
    SearchFilter::class, properties: ['city'=>'partial', 'name'=>'partial', 'owner'=>'exact']
)]
#[ORM\Entity(repositoryClass: SalonRepository::class)]
class Salon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([
        'hairdresser:read','user:hairdresser:read',
        'salon:read', 'salon:write', 'salon:put',
        'services:read',
        'workingHours:read',
        'ratings:read'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @Assert\Length(
     *     min=2
     * )
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    /**
     * @Assert\Length(
     *     min=2
     * )
     */
    #[Groups(['salon:read', 'salon:write','salon:put'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\Column]
    private ?bool $isActive = null;

    /**
     * @Assert\Length(
     *     min=6
     * )
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    /**
     * @Assert\Length(
     *     min=20,
     *     minMessage="Description of salon must be at least 20 characters long."
     * )
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    /**
     * @var string Name of image file with extension.
     * @Assert\Length(
     *     min=5,
     *     minMessage="Image file name must be at least 5 characters long."
     * )
     */
    #[Groups(['salon:write', 'salon:put'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imagePath = null;

    /**
     * @Assert\Valid()
     */
    #[Groups(['salon:read', 'salon:write','salon:put'])]
    #[ORM\OneToOne(inversedBy: 'salon', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[Groups(['salon:read'])]
    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonRating::class)]
    private Collection $rating;

    /**
     * @Assert\Valid()
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonWorkingHours::class, cascade: ['persist', 'remove'])]
    private Collection $salonWorkingHours;

    /**
     * @Assert\Valid()
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put'])]
    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: SalonServices::class, cascade: ['persist', 'remove'])]
    private Collection $salonServices;

    /**
     * @Assert\Valid()
     */
    #[Groups(['salon:read'])]
    #[ORM\OneToMany(mappedBy: 'salon', targetEntity: HairdresserDetails::class)]
    private Collection $hairdresser;

    public function __construct()
    {
        $this->rating = new ArrayCollection();
        $this->salonWorkingHours = new ArrayCollection();
        $this->salonServices = new ArrayCollection();
        $this->hairdresser = new ArrayCollection();
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

    /**
     * @return Collection<int, HairdresserDetails>
     */
    public function getHairdresser(): Collection
    {
        return $this->hairdresser;
    }

    public function addHairdresser(HairdresserDetails $hairdresser): self
    {
        if (!$this->hairdresser->contains($hairdresser)) {
            $this->hairdresser->add($hairdresser);
            $hairdresser->setSalon($this);
        }

        return $this;
    }

    public function removeHairdresser(HairdresserDetails $hairdresser): self
    {
        if ($this->hairdresser->removeElement($hairdresser)) {
            // set the owning side to null (unless already changed)
            if ($hairdresser->getSalon() === $this) {
                $hairdresser->setSalon(null);
            }
        }

        return $this;
    }
}
