<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrivateSpaceRepository")
 */
class PrivateSpace
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
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookingPrivate", mappedBy="space")
     */
    private $bookingPrivates;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $img;

    public function __construct()
    {

        $this->bookingPrivates = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
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


    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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
     * @return Collection|BookingPrivate[]
     */
    public function getBookingPrivates(): Collection
    {
        return $this->bookingPrivates;
    }

    public function addBookingPrivate(BookingPrivate $bookingPrivate): self
    {
        if (!$this->bookingPrivates->contains($bookingPrivate)) {
            $this->bookingPrivates[] = $bookingPrivate;
            $bookingPrivate->setSpace($this);
        }

        return $this;
    }

    public function removeBookingPrivate(BookingPrivate $bookingPrivate): self
    {
        if ($this->bookingPrivates->contains($bookingPrivate)) {
            $this->bookingPrivates->removeElement($bookingPrivate);
            // set the owning side to null (unless already changed)
            if ($bookingPrivate->getSpace() === $this) {
                $bookingPrivate->setSpace(null);
            }
        }

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
