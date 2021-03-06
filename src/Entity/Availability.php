<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvailabilityRepository")
 * @UniqueEntity(
 *     fields={"branch", "workdate"},
 *     errorPath="workdate",
 *     message="Op deze datum is bij dit filiaal al een afspraak gepland, kies een andere datum.")
 */
class Availability
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $branch;

    /**
     * @ORM\Column(type="date")
     */
    private $workdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $hours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBranch(): ?string
    {
        return $this->branch;
    }

    public function setBranch(string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function getWorkdate(): ?\DateTimeInterface
    {
        return $this->workdate;
    }

    public function setWorkdate(\DateTimeInterface $workdate): self
    {
        $this->workdate = $workdate;

        return $this;
    }

    public function getHours(): ?int
    {
        return $this->hours;
    }

    public function setHours(int $hours): self
    {
        $this->hours = $hours;

        return $this;
    }
}
