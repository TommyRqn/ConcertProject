<?php

namespace App\Entity;

use App\Repository\HallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HallRepository::class)
 */
class Hall
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $capacity;

    /**
     * @ORM\Column(type="boolean")
     */
    private $available;

    /**
     * @ORM\OneToMany(targetEntity=ConcertHall::class, mappedBy="hall")
     */
    private $concertHalls;

    /**
     * @ORM\OneToMany(targetEntity=Concert::class, mappedBy="hall")
     */
    private $concerts;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    public function __construct()
    {
        $this->concertHalls = new ArrayCollection();
        $this->concerts = new ArrayCollection();
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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getAvailable(): ?bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    /**
     * @return Collection|ConcertHall[]
     */
    public function getConcertHalls(): Collection
    {
        return $this->concertHalls;
    }

    public function addConcertHall(ConcertHall $concertHall): self
    {
        if (!$this->concertHalls->contains($concertHall)) {
            $this->concertHalls[] = $concertHall;
            $concertHall->setHall($this);
        }

        return $this;
    }

    public function removeConcertHall(ConcertHall $concertHall): self
    {
        if ($this->concertHalls->removeElement($concertHall)) {
            // set the owning side to null (unless already changed)
            if ($concertHall->getHall() === $this) {
                $concertHall->setHall(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Concert[]
     */
    public function getConcerts(): Collection
    {
        return $this->concerts;
    }

    public function addConcert(Concert $concert): self
    {
        if (!$this->concerts->contains($concert)) {
            $this->concerts[] = $concert;
            $concert->setHall($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getHall() === $this) {
                $concert->setHall(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
}
