<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filename = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Invitation $invitation = null;

    #[ORM\Column]
    private ?bool $released = null;

    public function __construct()
    {
        $this->released = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getInvitation(): ?Invitation
    {
        return $this->invitation;
    }

    public function setInvitation(?Invitation $invitation): static
    {
        $this->invitation = $invitation;

        return $this;
    }

    public function isReleased(): ?bool
    {
        return $this->released;
    }

    public function setReleased(bool $released): static
    {
        $this->released = $released;

        return $this;
    }
}
