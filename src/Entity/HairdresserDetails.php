<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\HairdresserDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(denormalizationContext: ['groups' => ['hairdresser:write']]),
        new Put( denormalizationContext: ['groups' => ['hairdresser:put']]),
        new Delete()
    ],
    class: HairdresserDetails::class,
    normalizationContext: ['groups'=> ['hairdresser:read']]
)]

#[ApiResource(
    uriTemplate: '/users/{id}/hairdresser',
    operations: [new Get( normalizationContext: ['groups' => ['user:hairdresser:read']])],
    uriVariables: [
        'id' => new Link(
            fromProperty: 'hairdresserDetails',
            fromClass: User::class,
        )
    ]
)]
#[ORM\Entity(repositoryClass: HairdresserDetailsRepository::class)]
class HairdresserDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups([
        'hairdresser:read', 'hairdresser:write',
        'user:hairdresser:read',
        'salon:read'
    ])]
    #[ORM\OneToOne(inversedBy: 'hairdresserDetails', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @Assert\Length(
     *     min=50,
     *     minMessage="Biography must be longer than 50 characters."
     * )
     */
    #[Groups([
        'hairdresser:read', 'hairdresser:write', 'hairdresser:put',
        'user:hairdresser:read'
    ])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $biography = null;

    #[Groups([
        'hairdresser:read', 'hairdresser:write', 'hairdresser:put',
        'user:hairdresser:read',
    ])]
    #[ORM\Column]
    private ?bool $isActive = null;

    #[Groups([
        'hairdresser:read', 'hairdresser:write', 'hairdresser:put',
        'user:hairdresser:read'
    ])]
    #[ORM\ManyToOne(inversedBy: 'hairdresser')]
    private ?Salon $salon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;

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

    public function getSalon(): ?Salon
    {
        return $this->salon;
    }

    public function setSalon(?Salon $salon): self
    {
        $this->salon = $salon;

        return $this;
    }
}
