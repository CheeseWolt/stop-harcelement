<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Veuillez saisir un Nom d'utilisateur")
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez saisir un Nom")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Veuillez saisir un Prénom")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\Length(max=10,maxMessage="Le numéro de téléphone ne doit pas dépasser 10 caractères")
     * @Assert\Type("numeric",message="Le numéro doit être composé de nombres")
     */
    private $phone;



    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Veuillez saisir une adresse")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="alertSender")
     */
    private $alerts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sex", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sex;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassName", inversedBy="userStudent")
     */
    private $studentClassName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClassName", mappedBy="userManager")
     */
    private $teacherClassName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PrivateMessage", mappedBy="user")
     */
    private $privateMessages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="L'email entré n'est pas valide")
     */
    private $email;

    public function __construct()
    {
        $this->alerts = new ArrayCollection();
        $this->teacherClassName = new ArrayCollection();
        $this->privateMessages = new ArrayCollection();
    }

    public function __toString()
    {
        return  $this->getLastName() . ' ' . $this->getFirstName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Alert[]
     */
    public function getAlerts(): Collection
    {
        return $this->alerts;
    }

    public function addAlert(Alert $alert): self
    {
        if (!$this->alerts->contains($alert)) {
            $this->alerts[] = $alert;
            $alert->setAlertSender($this);
        }

        return $this;
    }

    public function removeAlert(Alert $alert): self
    {
        if ($this->alerts->contains($alert)) {
            $this->alerts->removeElement($alert);
            // set the owning side to null (unless already changed)
            if ($alert->getAlertSender() === $this) {
                $alert->setAlertSender(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getSex(): ?Sex
    {
        return $this->sex;
    }

    public function setSex(?Sex $sex): self
    {
        $this->sex = $sex;

        return $this;
    }

    public function getStudentClassName(): ?ClassName
    {
        return $this->studentClassName;
    }

    public function setStudentClassName(?ClassName $studentClassName): self
    {
        $this->studentClassName = $studentClassName;

        return $this;
    }

    /**
     * @return Collection|ClassName[]
     */
    public function getTeacherClassName(): Collection
    {
        return $this->teacherClassName;
    }

    public function addTeacherClassName(ClassName $teacherClassName): self
    {
        if (!$this->teacherClassName->contains($teacherClassName)) {
            $this->teacherClassName[] = $teacherClassName;
            $teacherClassName->setUserManager($this);
        }

        return $this;
    }

    public function removeTeacherClassName(ClassName $teacherClassName): self
    {
        if ($this->teacherClassName->contains($teacherClassName)) {
            $this->teacherClassName->removeElement($teacherClassName);
            // set the owning side to null (unless already changed)
            if ($teacherClassName->getUserManager() === $this) {
                $teacherClassName->setUserManager(null);
            }
        }

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
            $privateMessage->setUser($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): self
    {
        if ($this->privateMessages->contains($privateMessage)) {
            $this->privateMessages->removeElement($privateMessage);
            // set the owning side to null (unless already changed)
            if ($privateMessage->getUser() === $this) {
                $privateMessage->setUser(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getRoles()
    {
        $roles[]= $this->getRole()->getName();
        return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }
    public function serialize(): string
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return serialize([$this->id, $this->userName, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->userName, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

}
