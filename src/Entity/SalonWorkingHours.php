<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SalonWorkingHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(denormalizationContext: ['groups'=>['workingHours:write']]),
        new Put( denormalizationContext: ['groups'=>['workingHours:put']]),
        new Delete()
    ],
    class: SalonWorkingHours::class,
    normalizationContext: ['groups'=>['workingHours:read']]
)]
#[ApiResource(
    uriTemplate: 'salon/{id}/workingHours',
    operations: [ new GetCollection()],
    uriVariables: [
        'id'=> new Link(
            fromProperty: 'salonWorkingHours',
            fromClass: Salon::class
        )
    ]
)]

#[ApiFilter(
    SearchFilter::class, properties: ['salon'=>'exact']
)]
#[ORM\Entity(repositoryClass: SalonWorkingHoursRepository::class)]
class SalonWorkingHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['workingHours:write', 'workingHours:read'])]
    #[ORM\ManyToOne(inversedBy: 'salonWorkingHours')]
    private ?Salon $salon = null;

    /**
     * @var int Number of day (1-Mon, ..., 7-Sun)
     * @Assert\Range(
     *     min=1,
     *     max=7,
     *     invalidMessage="Number of day must be between 1(Mon) and 7(Sun)."
     * )
     */
    #[Groups([
        'salon:write', 'salon:put',
        'workingHours:write', 'workingHours:put'
    ])]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $day = null;

    #[Groups([
        'salon:write', 'salon:put',
        'workingHours:write', 'workingHours:put'
    ])]
    #[ORM\Column(type: Types::STRING, nullable: true)]
    private $openingAt = null;

    #[Groups([
        'salon:write', 'salon:put',
        'workingHours:write', 'workingHours:put'
    ])]
    #[ORM\Column(type: Types::STRING, nullable: true)]
    private $closingAt = null;

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

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    #[Groups([
        'salon:read',
        'workingHours:read'
    ])]
    #[SerializedName('day')]
    public function getDayName(): ?string
    {
        if($this->day == 1){
            return "Mon";
        }
        if($this->day == 2){
            return "Tue";
        }
        if($this->day == 3){
            return "Wed";
        }
        if($this->day == 4){
            return "Thu";
        }
        if($this->day == 5){
            return "Fri";
        }
        if($this->day == 6){
            return "Sat";
        }
        if($this->day == 7){
            return "Sun";
        }
        return null;
    }

    #[Groups([
        'salon:read',
        'workingHours:read'
    ])]
    #[SerializedName('workingHours')]
    public function getTotalWorkingHours():string
    {
        return  $this->openingAt . ' - ' . $this->closingAt;
    }

    public function getOpeningAt()
    {
        return $this->openingAt;
    }

    public function setOpeningAt($openingAt): self
    {
        $this->openingAt = $openingAt;

        return $this;
    }

    public function getClosingAt()
    {
        return $this->closingAt;
    }

    public function setClosingAt($closingAt): self
    {
        $this->closingAt = $closingAt;

        return $this;
    }
}