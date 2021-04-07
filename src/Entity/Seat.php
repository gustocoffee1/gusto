<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeatRepository")
 */
class Seat
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
    private $name;


    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingSeat", mappedBy="seat")
     */
    private $bookingSeats;



    public function __construct()
    {
        $this->bookingSeats = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }



    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $bookingSeat->setSeat($this);
        }

        return $this;
    }

    public function removeBookingSeat(BookingSeat $bookingSeat): self
    {
        if ($this->bookingSeats->contains($bookingSeat)) {
            $this->bookingSeats->removeElement($bookingSeat);
            // set the owning side to null (unless already changed)
            if ($bookingSeat->getSeat() === $this) {
                $bookingSeat->setSeat(null);
            }
        }

        return $this;
    }


}
