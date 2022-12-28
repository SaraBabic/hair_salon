<?php

namespace App\Entity;

use App\Repository\SalonWorkingHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalonWorkingHoursRepository::class)]
class SalonWorkingHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'salonWorkingHours')]
    private ?Salon $salon = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $day = null;

    #[ORM\Column(type: Types::STRING)]
    private $openingAt = null;

    #[ORM\Column(type: Types::STRING)]
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
