<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column]
    private ?bool $isVerified = false;

    #[ORM\OneToOne(mappedBy: 'owner', cascade: ['persist', 'remove'])]
    private ?Salon $salon = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SalonRating::class)]
    private Collection $salonRatings;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Reservation::class)]
    private Collection $customerReservations;

    #[ORM\OneToMany(mappedBy: 'hairdresser', targetEntity: Reservation::class)]
    private Collection $hairdresserReservations;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Logs::class)]
    private Collection $logs;

    public function __construct()
    {
        $this->salonRatings = new ArrayCollection();
        $this->customerReservations = new ArrayCollection();
        $this->hairdresserReservations = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getSalon(): ?Salon
    {
        return $this->salon;
    }

    public function setSalon(Salon $salon): self
    {
        // set the owning side of the relation if necessary
        if ($salon->getOwner() !== $this) {
            $salon->setOwner($this);
        }

        $this->salon = $salon;

        return $this;
    }

    /**
     * @return Collection<int, SalonRating>
     */
    public function getSalonRatings(): Collection
    {
        return $this->salonRatings;
    }

    public function addSalonRating(SalonRating $salonRating): self
    {
        if (!$this->salonRatings->contains($salonRating)) {
            $this->salonRatings->add($salonRating);
            $salonRating->setUser($this);
        }

        return $this;
    }

    public function removeSalonRating(SalonRating $salonRating): self
    {
        if ($this->salonRatings->removeElement($salonRating)) {
            // set the owning side to null (unless already changed)
            if ($salonRating->getUser() === $this) {
                $salonRating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getCustomerReservations(): Collection
    {
        return $this->customerReservations;
    }

    public function addCustomerReservation(Reservation $customerReservation): self
    {
        if (!$this->customerReservations->contains($customerReservation)) {
            $this->customerReservations->add($customerReservation);
            $customerReservation->setCustomer($this);
        }

        return $this;
    }

    public function removeCustomerReservation(Reservation $customerReservation): self
    {
        if ($this->customerReservations->removeElement($customerReservation)) {
            // set the owning side to null (unless already changed)
            if ($customerReservation->getCustomer() === $this) {
                $customerReservation->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getHairdresserReservations(): Collection
    {
        return $this->hairdresserReservations;
    }

    public function addHairdresserReservation(Reservation $hairdresserReservation): self
    {
        if (!$this->hairdresserReservations->contains($hairdresserReservation)) {
            $this->hairdresserReservations->add($hairdresserReservation);
            $hairdresserReservation->setHairdresser($this);
        }

        return $this;
    }

    public function removeHairdresserReservation(Reservation $hairdresserReservation): self
    {
        if ($this->hairdresserReservations->removeElement($hairdresserReservation)) {
            // set the owning side to null (unless already changed)
            if ($hairdresserReservation->getHairdresser() === $this) {
                $hairdresserReservation->setHairdresser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Logs>
     */
    public function getLogs(): Collection
    {
        return $this->logs;
    }

    public function addLog(Logs $log): self
    {
        if (!$this->logs->contains($log)) {
            $this->logs->add($log);
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Logs $log): self
    {
        if ($this->logs->removeElement($log)) {
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }

}
