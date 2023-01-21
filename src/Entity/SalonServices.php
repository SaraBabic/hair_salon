<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SalonServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>'services:write']),
        new Put( denormalizationContext: ['groups'=>'services:put']),
        new Delete()
    ],
    class: SalonServices::class,
    normalizationContext: ['group'=>['services:read']]
)]
#[ApiResource(
    uriTemplate: 'salon/{id}/services',
    operations: [ new GetCollection()],
    uriVariables: [
        'id'=> new Link(
            fromProperty: 'salonServices',
            fromClass: Salon::class
        )
    ]
)]
#[ApiFilter(
    SearchFilter::class, properties: ['price'=>'exact', 'name'=>'partial', 'duration'=>'exact', 'salon'=>'exact']
)]
#[ApiFilter(
    RangeFilter::class, properties: ['price']
)]
#[ORM\Entity(repositoryClass: SalonServicesRepository::class)]
class SalonServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['salon:read', 'salon:write', 'salon:put',
        'services:read', 'services:write', 'services:put'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var int Price in dinars.
     * @Assert\Range(
     *     min="100",
     *     minMessage="Price must be at least 100dinars."
     * )
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put',
        'services:read', 'services:write', 'services:put'])]
    #[ORM\Column]
    private ?int $price = null;

    /**
     * @var int Time in minutes: 30, 60, 120
     * @Assert\Range(
     *     min="30",
     *     max="120",
     *     minMessage="Duration of service must be at least 30 minutes.",
     *     maxMessage="Duration of service must be less than 120 minutes."
     * )
     */
    #[Groups(['salon:read', 'salon:write', 'salon:put',
        'services:read', 'services:write', 'services:put'])]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $duration = null;

    #[Groups(['services:read', 'services:write'])]
    #[ORM\ManyToOne(inversedBy: 'salonServices')]
    private ?Salon $salon = null;

    //TODO why is this showing on 'services:read'?
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
