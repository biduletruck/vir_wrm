<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderStatusRepository")
 */
class OrderStatus
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
    private $enable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="OrderStatus")
     */
    private $orderStatus;

    public function __construct()
    {
        $this->OrderStatus = new ArrayCollection();
        $this->orderStatus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

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

    public function __toString()
    {
        return $this->Name;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrderStatus(): Collection
    {
        return $this->orderStatus;
    }

    public function addOrderStatus(Orders $orderStatus): self
    {
        if (!$this->orderStatus->contains($orderStatus)) {
            $this->orderStatus[] = $orderStatus;
            $orderStatus->setOrderStatus($this);
        }

        return $this;
    }

    public function removeOrderStatus(Orders $orderStatus): self
    {
        if ($this->orderStatus->contains($orderStatus)) {
            $this->orderStatus->removeElement($orderStatus);
            // set the owning side to null (unless already changed)
            if ($orderStatus->getOrderStatus() === $this) {
                $orderStatus->setOrderStatus(null);
            }
        }

        return $this;
    }
}
