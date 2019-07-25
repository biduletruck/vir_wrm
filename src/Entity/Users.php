<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 * @UniqueEntity("Username")
 */
class Users implements UserInterface, \Serializable
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
    private $LastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FirstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message = "L\'email '{{ value }}' n'est pas un email valide")
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 8, minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères")
     */
    private $Password;

    /**
     * @ORM\Column(type="json")
     */
    private $Roles = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $Account;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="User")
     */
    private $orders;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Storages", mappedBy="Login")
     */
    private $storages;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Labels", mappedBy="Login")
     */
    private $labels;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->storages = new ArrayCollection();
        $this->labels = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    /**
     * @param string $LastName
     * @return Users
     */
    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    /**
     * @param string $FirstName
     * @return Users
     */
    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->Email;
    }

    /**
     * @param string|null $Email
     * @return Users
     */
    public function setEmail(?string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->Username;
    }

    /**
     * @param string $Username
     * @return Users
     */
    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->Password;
    }

    /**
     * @param string $Password
     * @return Users
     */
    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        $roles = $this->Roles;

        return array_unique($roles);
    }

    /**
     * @param array $Roles
     * @return Users
     */
    public function setRoles(array $Roles): self
    {
        $this->Roles = $Roles;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getAccount(): ?bool
    {
        return $this->Account;
    }

    /**
     * @param bool $Account
     * @return Users
     */
    public function setAccount(bool $Account = true): self
    {
        $this->Account = $Account;

        return $this;
    }

    /**
     *
     */
    public function getSalt(): void
    {
    }

    /**
     *
     */
    public function eraseCredentials(): void
    {

    }

    /**
     * @return String
     */
    public function serialize(): String
    {
        return serialize([
            $this->id,
            $this->Username,
            $this->Password,
            $this->Roles
        ]);
    }

    /**
     * @param $serialize
     */
    public function unserialize($serialize): void
    {
        [
            $this->id,
            $this->Username,
            $this->Password,
            $this->Roles
        ] = unserialize($serialize, ['allowed_classes' => false]);
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

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
            $storage->setLogin($this);
        }

        return $this;
    }

    public function removeStorage(Storages $storage): self
    {
        if ($this->storages->contains($storage)) {
            $this->storages->removeElement($storage);
            // set the owning side to null (unless already changed)
            if ($storage->getLogin() === $this) {
                $storage->setLogin(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Labels[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Labels $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
            $label->setLogin($this);
        }

        return $this;
    }

    public function removeLabel(Labels $label): self
    {
        if ($this->labels->contains($label)) {
            $this->labels->removeElement($label);
            // set the owning side to null (unless already changed)
            if ($label->getLogin() === $this) {
                $label->setLogin(null);
            }
        }

        return $this;
    }
}
