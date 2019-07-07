<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConnectionHistoryRepository")
 */
class ConnectionHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ConnexionDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $IpAdress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Login;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Connection;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConnexionDate(): ?\DateTimeInterface
    {
        return $this->ConnexionDate;
    }

    public function setConnexionDate(\DateTimeInterface $ConnexionDate): self
    {
        $this->ConnexionDate = $ConnexionDate;

        return $this;
    }

    public function getIpAdress(): ?string
    {
        return $this->IpAdress;
    }

    public function setIpAdress(string $IpAdress): self
    {
        $this->IpAdress = $IpAdress;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): self
    {
        $this->Login = $Login;

        return $this;
    }

    public function getConnection(): ?bool
    {
        return $this->Connection;
    }

    public function setConnection(bool $Connection): self
    {
        $this->Connection = $Connection;

        return $this;
    }
}
