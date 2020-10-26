<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_client;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    public $confirm = false;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $clientArrived;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbClient(): ?int
    {
        return $this->nb_client;
    }

    public function setNbClient(int $nb_client): self
    {
        $this->nb_client = $nb_client;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getConfirm(): ?bool
    {
        return $this->confirm;
    }

    public function setConfirm(?bool $confirm): self
    {
        $this->confirm = $confirm;

        return $this;
    }

    public function getClientArrived(): ?bool
    {
        return $this->clientArrived;
    }

    public function setClientArrived(?bool $clientArrived): self
    {
        $this->clientArrived = $clientArrived;

        return $this;
    }
}
