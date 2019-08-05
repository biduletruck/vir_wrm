<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AgenciesRepository")
 */
class Agencies
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
    private $Name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enable;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Users", mappedBy="Agency")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Locations", mappedBy="Agency")
     */
    private $locations;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->locations = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
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

    public function getEnable(): ?bool
    {
        return $this->Enable;
    }

    public function setEnable(bool $Enable): self
    {
        $this->Enable = $Enable;

        return $this;
    }

    public function __toString()
    {
        return $this->Name;
    }

    /**
     * @return Collection|Users[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAgency($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeAgency($this);
        }

        return $this;
    }

    /**
     * @return Collection|Locations[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Locations $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setAgency($this);
        }

        return $this;
    }

    public function removeLocation(Locations $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getAgency() === $this) {
                $location->setAgency(null);
            }
        }

        return $this;
    }

}
