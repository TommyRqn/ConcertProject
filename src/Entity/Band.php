<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BandRepository::class)
 */
class Band
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
     * @ORM\Column(type="string", length=255)
     */
    private $style;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Member::class, mappedBy="band")
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity=Concert::class, mappedBy="band")
     */
    private $concerts;

    /**
     * @ORM\Column(type="date")
     */
    private $yearOfCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastAlbumName;

    public function __construct()
    {
        $this->members = new ArrayCollection();
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

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setBand($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->removeElement($member)) {
            // set the owning side to null (unless already changed)
            if ($member->getBand() === $this) {
                $member->setBand(null);
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
            $concert->setBand($this);
        }

        return $this;
    }

    public function removeConcert(Concert $concert): self
    {
        if ($this->concerts->removeElement($concert)) {
            // set the owning side to null (unless already changed)
            if ($concert->getBand() === $this) {
                $concert->setBand(null);
            }
        }

        return $this;
    }

    public function getYearOfCreation(): ?\DateTimeInterface
    {
        return $this->yearOfCreation;
    }

    public function setYearOfCreation(\DateTimeInterface $yearOfCreation): self
    {
        $this->yearOfCreation = $yearOfCreation;

        return $this;
    }

    public function getLastAlbumName(): ?string
    {
        return $this->lastAlbumName;
    }

    public function setLastAlbumName(?string $lastAlbumName): self
    {
        $this->lastAlbumName = $lastAlbumName;

        return $this;
    }
}
