<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductListingRepository")
 */
class ProductListing
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
    private $ProductNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="productListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FamilyProduct", inversedBy="productListings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $FamilyProduct;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storages", mappedBy="Product", orphanRemoval=true)
     */
    private $storages;

    public function __construct()
    {
        $this->storages = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductNumber(): ?string
    {
        return $this->ProductNumber;
    }

    public function setProductNumber(string $ProductNumber): self
    {
        $this->ProductNumber = $ProductNumber;

        return $this;
    }

    public function getOrderNumber(): ?Orders
    {
        return $this->OrderNumber;
    }

    public function setOrderNumber(?Orders $OrderNumber): self
    {
        $this->OrderNumber = $OrderNumber;

        return $this;
    }

    public function getFamilyProduct(): ?FamilyProduct
    {
        return $this->FamilyProduct;
    }

    public function setFamilyProduct(?FamilyProduct $FamilyProduct): self
    {
        $this->FamilyProduct = $FamilyProduct;

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
            $storage->setProduct($this);
        }

        return $this;
    }

    public function removeStorage(Storages $storage): self
    {
        if ($this->storages->contains($storage)) {
            $this->storages->removeElement($storage);
            // set the owning side to null (unless already changed)
            if ($storage->getProduct() === $this) {
                $storage->setProduct(null);
            }
        }

        return $this;
    }



}
