<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     normalizationContext={
 *     "groups"={"teachers:read", "teachers:write"},
 *     "enable_max_depth"=true
 *     },
 *     denormalizationContext={
 *     "groups"={"teachers:write"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 */
class Teacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"teachers:read", "vakken:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"teachers:read", "teachers:write","vakken:read"})
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"teachers:read", "teachers:write","vakken:read"})
     */
    private $voornaam;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"teachers:read", "teachers:write", "vakken:read"})
     */
    private $geboortedatum;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"teachers:read", "teachers:write", "vakken:read"})
     */
    private $specialisatie;

    /**
     * @ORM\OneToMany(targetEntity=VakTeacher::class, mappedBy="teacher", orphanRemoval=true)
     * @Groups({"teachers:read","teachers:write"})
     * @MaxDepth(1)
     */
    private $vakken;



    public function __construct()
    {
        $this->vakken = new ArrayCollection();
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

    public function getVoornaam(): ?string
    {
        return $this->voornaam;
    }

    public function setVoornaam(?string $voornaam): self
    {
        $this->voornaam = $voornaam;

        return $this;
    }

    public function getGeboortedatum(): ?\DateTimeInterface
    {
        return $this->geboortedatum;
    }

    public function setGeboortedatum(?\DateTimeInterface $geboortedatum): self
    {
        $this->geboortedatum = $geboortedatum;

        return $this;
    }

    public function getSpecialisatie(): ?string
    {
        return $this->specialisatie;
    }

    public function setSpecialisatie(?string $specialisatie): self
    {
        $this->specialisatie = $specialisatie;

        return $this;
    }

    /**
     * @return Collection<int, VakTeacher>
     */
    public function getVakken(): Collection
    {
        return $this->vakken;
    }

    public function addVakken(VakTeacher $vakken): self
    {
        if (!$this->vakken->contains($vakken)) {
            $this->vakken[] = $vakken;
            $vakken->setTeacher($this);
        }

        return $this;
    }

    public function removeVakken(VakTeacher $vakken): self
    {
        if ($this->vakken->removeElement($vakken)) {
            // set the owning side to null (unless already changed)
            if ($vakken->getTeacher() === $this) {
                $vakken->setTeacher(null);
            }
        }

        return $this;
    }
}
