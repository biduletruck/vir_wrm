<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
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
    private $OrderingNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $VirLocalNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CustomerName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateEntry;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DelivryDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ReturnType", cascade={"persist", "remove"})
     */
    private $ReturnType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StatusOrder", cascade={"persist", "remove"})
     */
    private $Status;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DetailOrder", mappedBy="orders")
     */
    private $DetailOrder;

    public function __construct()
    {
        $this->DetailOrder = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderingNumber(): ?string
    {
        return $this->OrderingNumber;
    }

    public function setOrderingNumber(string $OrderingNumber): self
    {
        $this->OrderingNumber = $OrderingNumber;

        return $this;
    }

    public function getVirLocalNumber(): ?string
    {
        return $this->VirLocalNumber;
    }

    public function setVirLocalNumber(string $VirLocalNumber): self
    {
        $this->VirLocalNumber = $VirLocalNumber;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->CustomerName;
    }

    public function setCustomerName(string $CustomerName): self
    {
        $this->CustomerName = $CustomerName;

        return $this;
    }

    public function getDateEntry(): ?\DateTimeInterface
    {
        return $this->DateEntry;
    }

    public function setDateEntry(\DateTimeInterface $DateEntry): self
    {
        $this->DateEntry = $DateEntry;

        return $this;
    }

    public function getDelivryDate(): ?\DateTimeInterface
    {
        return $this->DelivryDate;
    }

    public function setDelivryDate(\DateTimeInterface $DelivryDate): self
    {
        $this->DelivryDate = $DelivryDate;

        return $this;
    }

    public function getReturnType(): ?ReturnType
    {
        return $this->ReturnType;
    }

    public function setReturnType(?ReturnType $ReturnType): self
    {
        $this->ReturnType = $ReturnType;

        return $this;
    }

    public function getStatus(): ?StatusOrder
    {
        return $this->Status;
    }

    public function setStatus(?StatusOrder $Status): self
    {
        $this->Status = $Status;

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

    /**
     * @return Collection|DetailOrder[]
     */
    public function getDetailOrder(): Collection
    {
        return $this->DetailOrder;
    }

    public function addDetailOrder(DetailOrder $detailOrder): self
    {
        if (!$this->DetailOrder->contains($detailOrder)) {
            $this->DetailOrder[] = $detailOrder;
            $detailOrder->setOrders($this);
        }

        return $this;
    }

    public function removeDetailOrder(DetailOrder $detailOrder): self
    {
        if ($this->DetailOrder->contains($detailOrder)) {
            $this->DetailOrder->removeElement($detailOrder);
            // set the owning side to null (unless already changed)
            if ($detailOrder->getOrders() === $this) {
                $detailOrder->setOrders(null);
            }
        }

        return $this;
    }
}
