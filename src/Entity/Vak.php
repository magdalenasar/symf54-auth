<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VakRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     normalizationContext={
 *          "groups"={"vakken:read"},
 *          "enable_max_depth"=true
 *     },
 * )
 * @ORM\Entity(repositoryClass=VakRepository::class)
 */
// "teachers:read"
class Vak
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"vakken:read", "teachers:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"vakken:read", "teachers:read"})
     */
    private $naam;

    /**
     * @ORM\OneToMany(targetEntity=VakTeacher::class, mappedBy="vak", orphanRemoval=true)
     * @Groups({"vakken:read"})
     * @MaxDepth(1)
     */
    private $teachers;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * @return Collection<int, VakTeacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(VakTeacher $teacher): self
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers[] = $teacher;
            $teacher->setVak($this);
        }

        return $this;
    }

    public function removeTeacher(VakTeacher $teacher): self
    {
        if ($this->teachers->removeElement($teacher)) {
            // set the owning side to null (unless already changed)
            if ($teacher->getVak() === $this) {
                $teacher->setVak(null);
            }
        }

        return $this;
    }
}
