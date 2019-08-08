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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agencies", inversedBy="locations")
     */
    private $Agency;

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Labels", mappedBy="Location")
     */
    private $labels;

    private $Allee;

    private $Lice;

    private $Alveole;

    public function __construct()
    {
        $this->storages = new ArrayCollection();
        $this->labels = new ArrayCollection();

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

    public function getAgency(): ?Agencies
    {
        return $this->Agency;
    }

    public function setAgency(?Agencies $Agency): self
    {
        $this->Agency = $Agency;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|Labels[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Labels $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
            $label->setLocation($this);
        }

        return $this;
    }

    public function removeLabel(Labels $label): self
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
            // set the owning side to null (unless already changed)
            if ($label->getLocation() === $this) {
                $label->setLocation(null);
            }
        }

        return $this;
    }
    /**
     * @return mixed
     */
    public function getAllee()
    {
        return $this->Allee;
    }

    /**
     * @param mixed $Allee
     * @return Locations
     */
    public function setAllee($Allee)
    {
        $this->Allee = $Allee;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLice()
    {
        return $this->Lice;
    }

    /**
     * @param mixed $Lice
     * @return Locations
     */
    public function setLice($Lice)
    {
        $this->Lice = $Lice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlveole()
    {
        return $this->Alveole;
    }

    /**
     * @param mixed $Alveole
     * @return Locations
     */
    public function setAlveole($Alveole)
    {
        $this->Alveole = $Alveole;
        return $this;
    }


}
