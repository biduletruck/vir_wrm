<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoragesRepository")
 */
class Storages
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
     * @ORM\OneToOne(targetEntity="App\Entity\DetailOrder", cascade={"persist", "remove"})
     */
    private $DetailOrderNumber;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Locations", cascade={"persist", "remove"})
     */
    private $Socket;

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


    public function getDetailOrderNumber(): ?DetailOrder
    {
        return $this->DetailOrderNumber;
    }

    public function setDetailOrderNumber(?DetailOrder $DetailOrderNumber): self
    {
        $this->DetailOrderNumber = $DetailOrderNumber;

        return $this;
    }

    public function getSocket(): ?Locations
    {
        return $this->Socket;
    }

    public function setSocket(?Locations $Socket): self
    {
        $this->Socket = $Socket;

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
