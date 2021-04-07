<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingService", mappedBy="service", orphanRemoval=true)
     */
    private $bookingServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingPrivateService", mappedBy="private_service")
     */
    private $bookingPrivateServices;

    public function __construct()
    {
        $this->bookingServices = new ArrayCollection();
        $this->bookingPrivateServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

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
            $bookingService->setService($this);
        }

        return $this;
    }

    public function removeBookingService(BookingService $bookingService): self
    {
        if ($this->bookingServices->contains($bookingService)) {
            $this->bookingServices->removeElement($bookingService);
            // set the owning side to null (unless already changed)
            if ($bookingService->getService() === $this) {
                $bookingService->setService(null);
            }
        }

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
            $bookingPrivateService->setPrivateService($this);
        }

        return $this;
    }

    public function removeBookingPrivateService(BookingPrivateService $bookingPrivateService): self
    {
        if ($this->bookingPrivateServices->contains($bookingPrivateService)) {
            $this->bookingPrivateServices->removeElement($bookingPrivateService);
            // set the owning side to null (unless already changed)
            if ($bookingPrivateService->getPrivateService() === $this) {
                $bookingPrivateService->setPrivateService(null);
            }
        }

        return $this;
    }
}
