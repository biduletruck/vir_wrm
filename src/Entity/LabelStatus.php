<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LabelStatusRepository")
 */
class LabelStatus
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
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Enable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Labels", inversedBy="labelStatuses")
     */
    private $LabelStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->Enable;
    }

    public function setEnable(bool $Enable): self
    {
        $this->Enable = $Enable;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getLabelStatus(): ?Labels
    {
        return $this->LabelStatus;
    }

    public function setLabelStatus(?Labels $LabelStatus): self
    {
        $this->LabelStatus = $LabelStatus;

        return $this;
    }
}
