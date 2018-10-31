<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigurationRepository")
 */
class Configuration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=80)
     */
    protected $parameter;

    /**
     * @ORM\Column(type="text")
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConfigurationType", inversedBy="configurations")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $type;

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

    public function getParameter(): ?string
    {
        return $this->parameter;
    }

    public function setParameter(string $parameter): self
    {
        $this->parameter = $parameter;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?ConfigurationType
    {
        return $this->type;
    }

    public function setType(?ConfigurationType $type): self
    {
        $this->type = $type;

        return $this;
    }
}
