<?php

namespace App\Entity;

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



}
