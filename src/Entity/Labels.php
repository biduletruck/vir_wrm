<?php

namespace App\Entity;

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Locations", cascade={"persist", "remove"})
     */
    private $Location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="labels")
     */
    private $Login;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $LocationDate;

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

    public function getLocation(): ?Locations
    {
        return $this->Location;
    }

    public function setLocation(?Locations $Location): self
    {
        $this->Location = $Location;

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
}
