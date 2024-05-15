<?php

namespace App\Entity;

use App\Repository\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'applications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(length: 100)]
    private ?string $FIO = null;

    #[ORM\Column(length: 255)]
    private ?string $Text = null;

    #[ORM\Column(length: 100)]
    private ?string $City = null;

    #[ORM\Column(length: 100)]
    private ?string $Address = null;

    #[ORM\Column(nullable: true)]
    private ?float $Latitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $Longitude = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getFIO(): ?string
    {
        return $this->FIO;
    }

    public function setFIO(string $FIO): static
    {
        $this->FIO = $FIO;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): static
    {
        $this->Text = $Text;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): static
    {
        $this->City = $City;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->Latitude;
    }

    public function setLatitude(?float $Latitude): static
    {
        $this->Latitude = $Latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->Longitude;
    }

    public function setLongitude(?float $Longitude): static
    {
        $this->Longitude = $Longitude;

        return $this;
    }
}
