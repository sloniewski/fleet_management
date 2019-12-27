<?php

namespace App\Entity;

use App\Entity\Dictionaries\EngineType;
use App\Entity\Dictionaries\EngineVolume;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 */
class Model
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue();
     */
    private $brand_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dictionaries\EngineType")
     */
    private $engineType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dictionaries\EngineVolume")
     * @ORM\JoinColumn(nullable=false)
     */
    private $engineVolume;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getEngineType(): ?EngineType
    {
        return $this->engineType;
    }

    public function setEngineType(?EngineType $engineType): self
    {
        $this->engineType = $engineType;

        return $this;
    }

    public function getEngineVolume(): ?EngineVolume
    {
        return $this->engineVolume;
    }

    public function setEngineVolume(?EngineVolume $engineVolume): self
    {
        $this->engineVolume = $engineVolume;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }
}
