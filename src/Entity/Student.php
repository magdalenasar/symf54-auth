<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"students:read"}},
 *     denormalizationContext={"groups"={"students:write"}}
 * )
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"students:read", "students:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"students:read", "students:write"})
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"students:read", "students:write"})
     */
    private $voornaam;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $geboortedatum;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $punten;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $geslacht;

    /**
     * @ORM\OneToMany(targetEntity=PuntenDetail::class, mappedBy="student", orphanRemoval=true)
     */
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
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

    public function getGeboortedatum(): ?string
    {
        return $this->geboortedatum->format('Y-m-d');
    }

    public function setGeboortedatum(?\DateTimeInterface $geboortedatum): self
    {
        $this->geboortedatum = $geboortedatum;

        return $this;
    }

    public function getPunten(): ?int
    {
        return $this->punten;
    }

    public function setPunten(?int $punten): self
    {
        $this->punten = $punten;

        return $this;
    }

    public function getGeslacht(): ?int
    {
        return $this->geslacht;
    }

    public function setGeslacht(?int $geslacht): self
    {
        $this->geslacht = $geslacht;

        return $this;
    }

    /**
     * @return Collection<int, PuntenDetail>
     * @Groups({"students:read", "students:write"})
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(PuntenDetail $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setStudent($this);
        }

        return $this;
    }

    public function removeDetail(PuntenDetail $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getStudent() === $this) {
                $detail->setStudent(null);
            }
        }

        return $this;
    }
}
