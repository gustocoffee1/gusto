<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookings")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $booker;


    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="La date de début doit être au bon format ")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Date(message="La date de fin doit être au bon format ")
     * @Assert\GreaterThan(propertyPath="startDate", message="La date de fin doit être supérieure à la date de début")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $society;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingSeat", mappedBy="booking")
     */
    private $bookingSeats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingService", mappedBy="booking_service", orphanRemoval=true)
     */
    private $bookingServices;

    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
        $this->bookingServices = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooker(): ?User
    {
        return $this->booker;
    }

    public function setBooker(?User $booker): self
    {
        $this->booker = $booker;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSociety(): ?string
    {
        return $this->society;
    }

    public function setSociety(string $society): self
    {
        $this->society = $society;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|BookingSeat[]
     */
    public function getBookingSeats(): Collection
    {
        return $this->bookingSeats;
    }

    public function addBookingSeat(BookingSeat $bookingSeat): self
    {
        if (!$this->bookingSeats->contains($bookingSeat)) {
            $this->bookingSeats[] = $bookingSeat;
            $bookingSeat->setBooking($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): self
    {
        if ($this->bookingSeats->contains($bookingSeat)) {
            $this->bookingSeats->removeElement($bookingSeat);
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getBooking() === $this) {
                $bookingSeat->setBooking(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BookingService[]
     */
    public function getBookingServices(): Collection
    {
        return $this->bookingServices;
    }

    public function addBookingService(BookingService $bookingService): self
    {
        if (!$this->bookingServices->contains($bookingService)) {
            $this->bookingServices[] = $bookingService;
            $bookingService->setBookingService($this);
        }

        return $this;
    }

    public function removeBookingService(BookingService $bookingService): self
    {
        if ($this->bookingServices->contains($bookingService)) {
            $this->bookingServices->removeElement($bookingService);
            // set the owning side to null (unless already changed)
            if ($bookingService->getBookingService() === $this) {
                $bookingService->setBookingService(null);
            }
        }

        return $this;
    }




}
