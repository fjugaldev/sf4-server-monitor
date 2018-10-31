<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonitorHistoryRepository")
 */
class MonitorHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $serverStatus;

    /**
     * @ORM\Column(type="integer")
     */
    protected $responseCode;

    /**
     * @ORM\Column(type="float")
     */
    protected $loadTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Server", inversedBy="MonitorHistory")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $server;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"}))
     */
    protected $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServerStatus(): ?string
    {
        return $this->serverStatus;
    }

    public function setServerStatus(string $serverStatus): self
    {
        $this->serverStatus = $serverStatus;

        return $this;
    }

    public function getResponseCode(): ?int
    {
        return $this->responseCode;
    }

    public function setResponseCode(int $responseCode): self
    {
        $this->responseCode = $responseCode;

        return $this;
    }

    public function getLoadTime(): ?float
    {
        return $this->loadTime;
    }

    public function setLoadTime(float $loadTime): self
    {
        $this->loadTime = $loadTime;

        return $this;
    }

    public function getServer(): ?Server
    {
        return $this->server;
    }

    public function setServer(?Server $server): self
    {
        $this->server = $server;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
