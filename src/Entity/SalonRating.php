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
use App\Repository\SalonRatingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['ratings:write']]),
        new Delete()
    ],
    class: SalonRating::class,
    normalizationContext: ['groups'=>['ratings:read']]
)]
#[ApiResource(
    uriTemplate: 'salon/{id}/ratings',
    operations: [ new GetCollection()],
    uriVariables: [
        'id'=> new Link(
            fromProperty: 'rating',
            fromClass: Salon::class
        )
    ]
)]

#[ApiFilter(
    SearchFilter::class, properties: ['user'=>'exact', 'rate'=>'exact', 'salon'=>'exact']
)]
#[ApiFilter(
    RangeFilter::class, properties: ['rate']
)]
#[ORM\Entity(repositoryClass: SalonRatingRepository::class)]
class SalonRating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['ratings:read', 'ratings:write'])]
    #[ORM\ManyToOne(inversedBy: 'rating')]
    private ?Salon $salon = null;

    #[Groups([
        'salon:read',
        'ratings:read', 'ratings:write'
    ])]
    #[ORM\ManyToOne(inversedBy: 'salonRatings')]
    private ?User $user = null;

    /**
     * @var int Rate: 1(Bad)...5(Excellent)
     * @Assert\Range(
     *     min=1,
     *     max=5,
     *     invalidMessage="Rate must be from 1 to 5."
     * )
     */
    #[Groups([
        'salon:read',
        'ratings:read', 'ratings:write'
    ])]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $rate = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
