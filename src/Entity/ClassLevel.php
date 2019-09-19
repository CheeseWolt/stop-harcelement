<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassLevelRepository")
 */
class ClassLevel
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
     * @ORM\OneToMany(targetEntity="App\Entity\ClassName", mappedBy="classLevel")
     */
    private $classNames;

    public function __construct()
    {
        $this->classNames = new ArrayCollection();
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
     * @return Collection|ClassName[]
     */
    public function getClassNames(): Collection
    {
        return $this->classNames;
    }

    public function addClassName(ClassName $className): self
    {
        if (!$this->classNames->contains($className)) {
            $this->classNames[] = $className;
            $className->setClassLevel($this);
        }

        return $this;
    }

    public function removeClassName(ClassName $className): self
    {
        if ($this->classNames->contains($className)) {
            $this->classNames->removeElement($className);
            // set the owning side to null (unless already changed)
            if ($className->getClassLevel() === $this) {
                $className->setClassLevel(null);
            }
        }

        return $this;
    }
}
