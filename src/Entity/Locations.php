<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationsRepository")
 */
class Locations
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
    private $Location;

    /**
     * @ORM\Column(type="boolean")
     */
    private $FreePlace;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storages", mappedBy="Location")
     */
    private $storages;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $driveway;

    public function __construct()
    {
        $this->storages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getFreePlace(): ?bool
    {
        return $this->FreePlace;
    }

    public function setFreePlace(bool $FreePlace): self
    {
        $this->FreePlace = $FreePlace;

        return $this;
    }

    /**
     * @return Collection|Storages[]
     */
    public function getStorages(): Collection
    {
        return $this->storages;
    }

    public function addStorage(Storages $storage): self
    {
        if (!$this->storages->contains($storage)) {
            $this->storages[] = $storage;
            $storage->setLocation($this);
        }

        return $this;
    }

    public function removeStorage(Storages $storage): self
    {
        if ($this->storages->contains($storage)) {
            $this->storages->removeElement($storage);
            // set the owning side to null (unless already changed)
            if ($storage->getLocation() === $this) {
                $storage->setLocation(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->Location;
    }

    public function getDriveway(): ?string
    {
        return $this->driveway;
    }

    public function setDriveway(string $driveway): self
    {
        $this->driveway = $driveway;

        return $this;
    }
}
