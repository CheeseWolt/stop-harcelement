<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassNameRepository")
 */
class ClassName
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="studentClassName")
     */
    private $userStudent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="teacherClassName")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userManager;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ClassLevel", inversedBy="classNames")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classLevel;

    public function __toString()
    {
        return  $this->getClassLevel()->getName() . ' ' . $this->getName();
    }

    public function __construct()
    {
        $this->userStudent = new ArrayCollection();
    }

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

    /**
     * @return Collection|User[]
     */
    public function getUserStudent(): Collection
    {
        return $this->userStudent;
    }

    public function addUserStudent(User $userStudent): self
    {
        if (!$this->userStudent->contains($userStudent)) {
            $this->userStudent[] = $userStudent;
            $userStudent->setStudentClassName($this);
        }

        return $this;
    }

    public function removeUserStudent(User $userStudent): self
    {
        if ($this->userStudent->contains($userStudent)) {
            $this->userStudent->removeElement($userStudent);
            // set the owning side to null (unless already changed)
            if ($userStudent->getStudentClassName() === $this) {
                $userStudent->setStudentClassName(null);
            }
        }

        return $this;
    }

    public function getUserManager(): ?User
    {
        return $this->userManager;
    }

    public function setUserManager(?User $userManager): self
    {
        $this->userManager = $userManager;

        return $this;
    }

    public function getClassLevel(): ?ClassLevel
    {
        return $this->classLevel;
    }

    public function setClassLevel(?ClassLevel $classLevel): self
    {
        $this->classLevel = $classLevel;

        return $this;
    }
}
