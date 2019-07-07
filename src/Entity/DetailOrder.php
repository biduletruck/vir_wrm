<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DetailOrderRepository")
 */
class DetailOrder
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
    private $NumberDetail;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DetailOrderType", cascade={"persist", "remove"})
     */
    private $OrderType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="DetailOrder")
     */
    private $orders;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", cascade={"persist", "remove"})
     */
    private $User;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberDetail(): ?string
    {
        return $this->NumberDetail;
    }

    public function setNumberDetail(string $NumberDetail): self
    {
        $this->NumberDetail = $NumberDetail;

        return $this;
    }

    public function getOrderType(): ?DetailOrderType
    {
        return $this->OrderType;
    }

    public function setOrderType(?DetailOrderType $OrderType): self
    {
        $this->OrderType = $OrderType;

        return $this;
    }

    public function getOrders(): ?Orders
    {
        return $this->orders;
    }

    public function setOrders(?Orders $orders): self
    {
        $this->orders = $orders;

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
