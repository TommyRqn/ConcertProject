<?php

namespace App\Entity;

use App\Repository\ConcertRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConcertRepository::class)
 * @ORM\Table(name="`concert`")
 */
class Concert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=Band::class, inversedBy="concerts")
     */
    private $band;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tourname;

    /**
     * @ORM\ManyToOne(targetEntity=Hall::class, inversedBy="concerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hall;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): self
    {
        $this->band = $band;

        return $this;
    }

    public function getTourName(): ?string
    {
        return $this->tourname;
    }

    public function setTourName(string $tourname): self
    {
        $this->tourname = $tourname;

        return $this;
    }

    public function getHall(): ?Hall
    {
        return $this->hall;
    }

    public function setHall(?Hall $hall): self
    {
        $this->hall = $hall;

        return $this;
    }
}
