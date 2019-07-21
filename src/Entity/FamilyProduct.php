<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamilyProductRepository")
 */
class FamilyProduct
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
     * @ORM\OneToMany(targetEntity="App\Entity\ProductListing", mappedBy="FamilyProduct")
     */
    private $productListings;

    public function __construct()
    {
        $this->Orders = new ArrayCollection();
        $this->productListings = new ArrayCollection();
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

    /**
     * @return Collection|ProductListing[]
     */
    public function getOrders(): Collection
    {
        return $this->Orders;
    }

    public function addOrder(ProductListing $order): self
    {
        if (!$this->Orders->contains($order)) {
            $this->Orders[] = $order;
            $order->setFamilyProduct($this);
        }

        return $this;
    }

    public function removeOrder(ProductListing $order): self
    {
        if ($this->Orders->contains($order)) {
            $this->Orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getFamilyProduct() === $this) {
                $order->setFamilyProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductListing[]
     */
    public function getProductListings(): Collection
    {
        return $this->productListings;
    }

    public function addProductListing(ProductListing $productListing): self
    {
        if (!$this->productListings->contains($productListing)) {
            $this->productListings[] = $productListing;
            $productListing->setFamilyProduct($this);
        }

        return $this;
    }

    public function removeProductListing(ProductListing $productListing): self
    {
        if ($this->productListings->contains($productListing)) {
            $this->productListings->removeElement($productListing);
            // set the owning side to null (unless already changed)
            if ($productListing->getFamilyProduct() === $this) {
                $productListing->setFamilyProduct(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->Name;
    }
}
