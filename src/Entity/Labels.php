<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabelsRepository")
 */
class Labels
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Orders", inversedBy="labels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $virLocalNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $localLabel;


    private $newLocation;

    private $lice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="labels")
     */
    private $Login;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $LocationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locations", inversedBy="labels")
     */
    private $Location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LabelStatus", mappedBy="LabelStatus")
     */
    private $labelStatuses;

    public function __construct()
    {
        $this->labelStatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVirLocalNumber(): ?Orders
    {
        return $this->virLocalNumber;
    }

    public function setVirLocalNumber(?Orders $virLocalNumber): self
    {
        $this->virLocalNumber = $virLocalNumber;

        return $this;
    }

    public function getLocalLabel(): ?string
    {
        return $this->localLabel;
    }

    public function setLocalLabel(string $localLabel): self
    {
        $this->localLabel = $localLabel;

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

    public function getLocationDate(): ?\DateTimeInterface
    {
        return $this->LocationDate;
    }

    public function setLocationDate(?\DateTimeInterface $LocationDate): self
    {
        $this->LocationDate = $LocationDate;

        return $this;
    }

    public function __toString()
    {
        return $this->virLocalNumber;
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

    /**
     * @return mixed
     */
    public function getLice()
    {
        return $this->lice;
    }

    /**
     * @param mixed $lice
     * @return Labels
     */
    public function setLice($lice)
    {
        $this->lice = $lice;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewLocation()
    {
        return $this->newLocation;
    }

    /**
     * @param mixed $newLocation
     * @return Labels
     */
    public function setNewLocation($newLocation)
    {
        $this->newLocation = $newLocation;
        return $this;
    }

    /**
     * @return Collection|LabelStatus[]
     */
    public function getLabelStatuses(): Collection
    {
        return $this->labelStatuses;
    }

    public function addLabelStatus(LabelStatus $labelStatus): self
    {
        if (!$this->labelStatuses->contains($labelStatus)) {
            $this->labelStatuses[] = $labelStatus;
            $labelStatus->setLabelStatus($this);
        }

        return $this;
    }

    public function removeLabelStatus(LabelStatus $labelStatus): self
    {
        if ($this->labelStatuses->contains($labelStatus)) {
            $this->labelStatuses->removeElement($labelStatus);
            // set the owning side to null (unless already changed)
            if ($labelStatus->getLabelStatus() === $this) {
                $labelStatus->setLabelStatus(null);
            }
        }

        return $this;
    }
}
