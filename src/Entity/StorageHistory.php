<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StorageHistoryRepository")
 */
class StorageHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $StorageDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Locations", cascade={"persist", "remove"})
     */
    private $location;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DetailOrder", cascade={"persist", "remove"})
     */
    private $DetailOrder;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", cascade={"persist", "remove"})
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStorageDate(): ?\DateTimeInterface
    {
        return $this->StorageDate;
    }

    public function setStorageDate(\DateTimeInterface $StorageDate): self
    {
        $this->StorageDate = $StorageDate;

        return $this;
    }

    public function getLocation(): ?Locations
    {
        return $this->location;
    }

    public function setLocation(?Locations $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDetailOrder(): ?DetailOrder
    {
        return $this->DetailOrder;
    }

    public function setDetailOrder(?DetailOrder $DetailOrder): self
    {
        $this->DetailOrder = $DetailOrder;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->User;
    }

    public function setUser(?Users $User): self
    {
        $this->User = $User;

        return $this;
    }
}
