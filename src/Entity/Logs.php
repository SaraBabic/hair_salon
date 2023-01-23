<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\LogsRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['log:write']])
    ],
    class: Logs::class,
    normalizationContext: ['groups' => ['log:read']]
)]
#[ORM\Entity(repositoryClass: LogsRepository::class)]
class Logs
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $deviceType = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $userAgent = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $ipAddress = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $continent = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $region = null;

    #[Groups(['log:write', 'log:read'])]
    #[ORM\Column(length: 255)]
    private ?string $provider = null;

    /**
     * @var string User's IRI
     */
    #[Groups(['log:write', 'log:read'])]
    #[ORM\ManyToOne(inversedBy: 'logs')]
    private ?User $user = null;

    public function __construct(){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(string $deviceType): self
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function setUserAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(string $continent): self
    {
        $this->continent = $continent;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getProvider(): ?string
    {
        return $this->provider;
    }

    public function setProvider(string $provider): self
    {
        $this->provider = $provider;

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
}
