<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Model")
     */
    private $model;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Color")
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="car", orphanRemoval=true)
     */
    private $events;

    /**
     * @ORM\Column(type="string", length=128, nullable=true, unique=true)
     */
    private $plates;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver", inversedBy="cars")
     */
    private $driver;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

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

    public function getColor(): ?Color
    {
        return $this->color;
    }

    public function setColor(?Color $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->getModel() ? $this->getModel()->getBrand() : null;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setCar($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getCar() === $this) {
                $event->setCar(null);
            }
        }

        return $this;
    }

    public function getPlates(): ?string
    {
        return $this->plates;
    }

    public function setPlates(?string $plates): self
    {
        $this->plates = $plates;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }
}
