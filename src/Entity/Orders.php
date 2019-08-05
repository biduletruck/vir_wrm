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
     * @ORM\Column(type="date")
     */
    private $DelivryDate;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="orders")
     */
    private $User;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductListing", mappedBy="OrderNumber",orphanRemoval=true)
     */
    private $productListings;


    /**
     * @ORM\Column(type="integer")
     */
    private $Labels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Labels", mappedBy="virLocalNumber", orphanRemoval=true)
     */
    private $labels;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Statuts = 1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Companies", inversedBy="orders")
     */
    private $Company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Agencies", inversedBy="orders")
     */
    private $Agency;



    public function __construct()
    {
        $this->DateEntry = new \DateTime();
        $this->productListings = new ArrayCollection();
        $this->labels = new ArrayCollection();


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

    /**
     * @return mixed
     */
    public function getDelivryDate(): ?\DateTimeInterface
    {
        return $this->DelivryDate;
    }

    /**
     * @param mixed $DelivryDate
     * @return Orders
     */
    public function setDelivryDate($DelivryDate)
    {
        $this->DelivryDate = $DelivryDate;
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
            $productListing->setOrderNumber($this);
        }

        return $this;
    }

    public function removeProductListing(ProductListing $productListing): self
    {
        if ($this->productListings->contains($productListing)) {
            $this->productListings->removeElement($productListing);
            // set the owning side to null (unless already changed)
            if ($productListing->getOrderNumber() === $this) {
                $productListing->setOrderNumber(null);
            }
        }

        return $this;
    }


    public function getLabels(): ?int
    {
        return $this->Labels;
    }

    public function setLabels(int $Labels): self
    {
        $this->Labels = $Labels;

        return $this;
    }

    public function addLabel(Labels $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
            $label->setVirLocalNumber($this);
        }

        return $this;
    }

    public function removeLabel(Labels $label): self
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
            // set the owning side to null (unless already changed)
            if ($label->getVirLocalNumber() === $this) {
                $label->setVirLocalNumber(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->VirLocalNumber;
    }

    public function getStatuts(): ?bool
    {
        return $this->Statuts;
    }

    public function setStatuts(bool $Statuts): self
    {
        $this->Statuts = $Statuts;

        return $this;
    }

    public function getCompany(): ?Companies
    {
        return $this->Company;
    }

    public function setCompany(?Companies $Company): self
    {
        $this->Company = $Company;

        return $this;
    }

    public function getAgency(): ?Agencies
    {
        return $this->Agency;
    }

    public function setAgency(?Agencies $Agency): self
    {
        $this->Agency = $Agency;

        return $this;
    }



}
