<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\VakTeacherRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     normalizationContext={
 *     "groups"={},
 *     "enable_max_depth"=true
 *     },
 * )
 * @ORM\Entity(repositoryClass=VakTeacherRepository::class)
 */
//"teachers:read", "vakken:read",  "teachers:write"
class VakTeacher
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="vakken")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"vakken:read"})
     * @MaxDepth(1)
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity=Vak::class, inversedBy="teachers")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"teachers:read", "teachers:write"})
     * @MaxDepth(1)
     */
    private $vak;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getVak(): ?Vak
    {
        return $this->vak;
    }

    public function setVak(?Vak $vak): self
    {
        $this->vak = $vak;

        return $this;
    }
}
