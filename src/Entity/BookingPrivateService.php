<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingPrivateServiceRepository")
 */
class BookingPrivateService
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BookingPrivate", inversedBy="bookingPrivateServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $booking_private_service;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="bookingPrivateServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $private_service;

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

    public function getBookingPrivateService(): ?BookingPrivate
    {
        return $this->booking_private_service;
    }

    public function setBookingPrivateService(?BookingPrivate $booking_private_service): self
    {
        $this->booking_private_service = $booking_private_service;

        return $this;
    }

    public function getPrivateService(): ?Service
    {
        return $this->private_service;
    }

    public function setPrivateService(?Service $private_service): self
    {
        $this->private_service = $private_service;

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
