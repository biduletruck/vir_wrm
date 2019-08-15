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
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductListing", inversedBy="storages",cascade={"persist"})
     */
    private $Product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locations", inversedBy="storages",cascade={"persist"})
     */
    private $Location;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $LocationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="storages",cascade={"persist"})
     */
    private $Login;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?ProductListing
    {
        return $this->Product;
    }

    public function setProduct(?ProductListing $Product): self
    {
        $this->Product = $Product;

        return $this;
    }

    public function getLocation(): ?Locations
    {
        return $this->Location;
    }

    public function setLocation(?Locations $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    public function getLocationDate(): ?\DateTimeInterface
    {
        return $this->LocationDate;
    }

    public function setLocationDate(\DateTimeInterface $LocationDate): self
    {
        $this->LocationDate = $LocationDate;

        return $this;
    }

    public function getLogin(): ?Users
    {
        return $this->Login;
    }

    public function setLogin(?Users $Login): self
    {
        $this->Login = $Login;

        return $this;
    }
}
