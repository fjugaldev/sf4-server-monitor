<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServerRepository")
 */
class Server
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    protected $displayName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $url;

    /**
     * @ORM\Column(type="integer")
     */
    protected $checkEvery;

    /**
     * @ORM\Column(type="integer")
     */
    protected $timeout;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDisabled;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $notificationEmail;

    /**
     * @ORM\Column(type="string", length=40)
     */
    protected $notificationPhone;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $sendDesktopNotification;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $usePushBullet;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="servers")
     */
    protected $users;

    /**
     * @ORM\Column(type="datetime", nullable=true   )
     */
    protected $lastStatusVerification;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitorHistory", mappedBy="server")
     */
    protected $monitorHistory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="ownedServers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->lastStatusVerification = new \DateTime();
        $this->MonitorHistory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCheckEvery(): ?int
    {
        return $this->checkEvery;
    }

    public function setCheckEvery(int $checkEvery): self
    {
        $this->checkEvery = $checkEvery;

        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function getIsDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(bool $isDisabled): self
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    public function getNotificationEmail(): ?string
    {
        return $this->notificationEmail;
    }

    public function setNotificationEmail(string $notificationEmail): self
    {
        $this->notificationEmail = $notificationEmail;

        return $this;
    }

    public function getNotificationPhone(): ?string
    {
        return $this->notificationPhone;
    }

    public function setNotificationPhone(string $notificationPhone): self
    {
        $this->notificationPhone = $notificationPhone;

        return $this;
    }

    public function getSendDesktopNotification(): ?bool
    {
        return $this->sendDesktopNotification;
    }

    public function setSendDesktopNotification(bool $sendDesktopNotification): self
    {
        $this->sendDesktopNotification = $sendDesktopNotification;

        return $this;
    }

    public function getUsePushBullet(): ?bool
    {
        return $this->usePushBullet;
    }

    public function setUsePushBullet(bool $usePushBullet): self
    {
        $this->usePushBullet = $usePushBullet;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastStatusVerification()
    {
        return $this->lastStatusVerification;
    }

    /**
     * @param mixed $lastStatusVerification
     * @return self
     */
    public function setLastStatusVerification($lastStatusVerification): self
    {
        $this->lastStatusVerification = $lastStatusVerification;

        return $this;
    }

    /**
     * @return float
     */
    public function getLoadTime(): float
    {
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $start = $time;
        $url = file_get_contents($this->getUrl());
        $time = microtime();
        $time = explode(' ', $time);
        $time = $time[1] + $time[0];
        $finish = $time;
        $total_time = round(($finish - $start), 2);

        return $total_time;
    }

    /**
     * @return Collection|MonitorHistory[]
     */
    public function getMonitorHistory(): Collection
    {
        return $this->monitorHistory;
    }

    public function addMonitorHistory(MonitorHistory $monitorHistory): self
    {
        if (!$this->monitorHistory->contains($monitorHistory)) {
            $this->monitorHistory[] = $monitorHistory;
            $monitorHistory->setServer($this);
        }

        return $this;
    }

    public function removeMonitorHistory(MonitorHistory $monitorHistory): self
    {
        if ($this->monitorHistory->contains($monitorHistory)) {
            $this->monitorHistory->removeElement($monitorHistory);
            // set the owning side to null (unless already changed)
            if ($monitorHistory->getServer() === $this) {
                $monitorHistory->setServer(null);
            }
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
