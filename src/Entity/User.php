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
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post( denormalizationContext: ['groups'=>['user:write']]),
        new Put( denormalizationContext: ['groups'=>['user:put']]),
        new Delete()
    ],
    class: User::class,
    normalizationContext: ['groups'=>['user:read']],
)]
#[ApiFilter(
    BooleanFilter::class, properties: ['isBanned', 'isVerified']
)]
#[ApiFilter(
    SearchFilter::class, properties: ['firstName'=>'partial', 'lastName'=>'partial']
)]
//TODO searchFilter za role
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\Email()
     */
    #[Groups([
        'user:read', 'user:write',
        'log:read',
        'hairdresser:read', 'hairdresser:write',
        'user:hairdresser:read',
        'salon:read',
        'ratings:read',
        'reservation:read'
    ])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Groups([
        'user:write','user:put',
        'hairdresser:write'
    ])]
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     * @Assert\Length(
     *     min=8,
     *     minMessage="Password must be at least 8 characters long."
     * )
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @Assert\Length(
     *     min=2
     * )
     */
    #[Groups([
        'user:read','user:write', 'user:put',
        'hairdresser:read', 'hairdresser:write',
        'user:hairdresser:read', 'salon:read'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    /**
     * @Assert\Length(
     *     min=2
     * )
     */
    #[Groups(['user:read','user:write', 'user:put',
        'hairdresser:read', 'hairdresser:write',
        'user:hairdresser:read', 'salon:read'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    /**
     * @Assert\Length(
     *     min=6
     * )
     */
    #[Groups([
        'user:read','user:write', 'user:put',
        'hairdresser:write',
        'user:hairdresser:read'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[Groups([
        'user:read', 'user:write', 'user:put',
        'hairdresser:write',
        'user:hairdresser:read'
    ])]
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

    #[Groups([
        'user:read', 'user:write', 'user:put',
        'user:hairdresser:read'
    ])]
    #[ORM\Column]
    private ?bool $isBanned = false;

    #[ORM\OneToOne(mappedBy:'user', cascade: ['persist', 'remove'])]
    private ?HairdresserDetails $hairdresserDetails = null;

    public function __construct()
    {
        $this->salonRatings = new ArrayCollection();
        $this->customerReservations = new ArrayCollection();
        $this->hairdresserReservations = new ArrayCollection();
        $this->logs = new ArrayCollection();
    }

    public function __toString():string
    {
        return $this->lastName . ' ' . $this->firstName;
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

    #[SerializedName('roles')]
    #[Groups([
        'user:read',
        'user:hairdresser:read'
    ])]
    public function getRolesAsString()
    {
        return implode(',', $this->roles);
    }

    public function setRolesAsString(?string $roles = ''):self
    {
        $this->roles = explode(',', $roles);

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
     * @var string User's plain password
     */
    #[SerializedName('password')]
    #[Groups([
        'user:write','user:put',
        'hairdresser:write'
    ])]
    public function setPlainPassword(string $plainPass)
    {
        $this->password = password_hash($plainPass, PASSWORD_BCRYPT);
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

    public function isIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getHairdresserDetails(): ?HairdresserDetails
    {
        return $this->hairdresserDetails;
    }

    public function setHairdresserDetails(?HairdresserDetails $hairdresserDetails): self
    {
        $this->hairdresserDetails = $hairdresserDetails;

        return $this;
    }

}
