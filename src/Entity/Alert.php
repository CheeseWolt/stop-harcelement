<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AlertRepository")
 */
class Alert
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
    private $alertDate;

    /**
     * @ORM\Column(type="date")
     */
    private $eventDate;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $ipAddress;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startSupportDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endSupportDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $alertSender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="alerts")
     */
    private $alertManager;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status", inversedBy="alerts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="alert")
     */
    private $privateMessages;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AlertStyle", inversedBy="alerts")
     */
    private $alertStyle;

    /**
     * @ORM\Column(type="time")
     */
    private $eventTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isAnonym;

    public function __construct()
    {
        $this->alertDate = new DateTime();
        $this->privateMessages = new ArrayCollection();
        $this->alertStyle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlertDate(): ?\DateTimeInterface
    {
        return $this->alertDate;
    }

    public function setAlertDate(\DateTimeInterface $alertDate): self
    {
        $this->alertDate = $alertDate;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(\DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(string $ipAddress): self
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStartSupportDate(): ?\DateTimeInterface
    {
        return $this->startSupportDate;
    }

    public function setStartSupportDate(\DateTimeInterface $startSupportDate): self
    {
        $this->startSupportDate = $startSupportDate;

        return $this;
    }

    public function getEndSupportDate(): ?\DateTimeInterface
    {
        return $this->endSupportDate;
    }

    public function setEndSupportDate(?\DateTimeInterface $endSupportDate): self
    {
        $this->endSupportDate = $endSupportDate;

        return $this;
    }

    public function getAlertSender(): ?User
    {
        return $this->alertSender;
    }

    public function setAlertSender(?User $alertSender): self
    {
        $this->alertSender = $alertSender;

        return $this;
    }

    public function getAlertManager(): ?User
    {
        return $this->alertManager;
    }

    public function setAlertManager(?User $alertManager): self
    {
        $this->alertManager = $alertManager;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }


    /**
     * @return Collection|PrivateMessage[]
     */
    public function getPrivateMessages(): Collection
    {
        return $this->privateMessages;
    }

    public function addPrivateMessage(PrivateMessage $privateMessage): self
    {
        if (!$this->privateMessages->contains($privateMessage)) {
            $this->privateMessages[] = $privateMessage;
            $privateMessage->setAlert($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->contains($privateMessage)) {
            $this->privateMessages->removeElement($privateMessage);
            // set the owning side to null (unless already changed)
            if ($privateMessage->getAlert() === $this) {
                $privateMessage->setAlert(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AlertStyle[]
     */
    public function getAlertStyle(): Collection
    {
        return $this->alertStyle;
    }

    public function addAlertStyle(AlertStyle $alertStyle): self
    {
        if (!$this->alertStyle->contains($alertStyle)) {
            $this->alertStyle[] = $alertStyle;
        }

        return $this;
    }

    public function removeAlertStyle(AlertStyle $alertStyle): self
    {
        if ($this->alertStyle->contains($alertStyle)) {
            $this->alertStyle->removeElement($alertStyle);
        }

        return $this;
    }

    public function getEventTime(): ?\DateTimeInterface
    {
        return $this->eventTime;
    }

    public function setEventTime(\DateTimeInterface $eventTime): self
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    public function getIsAnonym(): ?bool
    {
        return $this->isAnonym;
    }

    public function setIsAnonym(bool $isAnonym): self
    {
        $this->isAnonym = $isAnonym;

        return $this;
    }
}
