<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingPrivateRepository")
 */
class BookingPrivate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PrivateSpace", inversedBy="bookingPrivates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $space;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookingPrivates")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $relation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\OneToMany(targetEntity="App\Entity\BookingPrivateService", mappedBy="booking_private_service", orphanRemoval=true)
     */
    private $bookingPrivateServices;

    public function __construct()
    {
        $this->bookingPrivateServices = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSpace(): ?PrivateSpace
    {
        return $this->space;
    }

    public function setSpace(?PrivateSpace $space): self
    {
        $this->space = $space;

        return $this;
    }

    public function getRelation(): ?User
    {
        return $this->relation;
    }

    public function setRelation(?User $relation): self
    {
        $this->relation = $relation;

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
     * @return Collection|BookingPrivateService[]
     */
    public function getBookingPrivateServices(): Collection
    {
        return $this->bookingPrivateServices;
    }

    public function addBookingPrivateService(BookingPrivateService $bookingPrivateService): self
    {
        if (!$this->bookingPrivateServices->contains($bookingPrivateService)) {
            $this->bookingPrivateServices[] = $bookingPrivateService;
            $bookingPrivateService->setBookingPrivateService($this);
        }

        return $this;
    }

    public function removeBookingPrivateService(BookingPrivateService $bookingPrivateService): self
    {
        if ($this->bookingPrivateServices->contains($bookingPrivateService)) {
            $this->bookingPrivateServices->removeElement($bookingPrivateService);
            // set the owning side to null (unless already changed)
            if ($bookingPrivateService->getBookingPrivateService() === $this) {
                $bookingPrivateService->setBookingPrivateService(null);
            }
        }

        return $this;
    }

}
