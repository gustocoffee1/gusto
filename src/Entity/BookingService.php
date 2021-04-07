<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingServiceRepository")
 */
class BookingService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\booking", inversedBy="bookingServices")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $booking_service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="bookingServices")
     * @ORM\JoinColumn(nullable=true)
     */
    private $service;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingService(): ?booking
    {
        return $this->booking_service;
    }

    public function setBookingService(?booking $booking_service): self
    {
        $this->booking_service = $booking_service;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getQuantity(): ?string
    {
        return $this->quantity;
    }

    public function setQuantity(string $quantity): self
    {
        $this->quantity = $quantity;

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
}
