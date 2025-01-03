<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: InvitationRepository::class)]
class Invitation
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[ORM\Column]
    private ?int $number_guests_invited = null;

    #[ORM\Column(nullable: true)]
    private ?int $number_guests_promised = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_invited = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_promised = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_must_promise = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?bool $is_family = null;

    #[ORM\Column(enumType: GuestTypeEnum::class)]
    private ?GuestTypeEnum $salutation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $guest_comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $promised = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $promised_date = null;

    public function __construct()
    {
        $this->is_family = false;
        $this->date_must_promise = new \DateTime('2025-04-30');
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getNumberGuestsInvited(): ?int
    {
        return $this->number_guests_invited;
    }

    public function setNumberGuestsInvited(int $number_guests_invited): static
    {
        $this->number_guests_invited = $number_guests_invited;

        return $this;
    }

    public function getNumberGuestsPromised(): ?int
    {
        return $this->number_guests_promised;
    }

    public function setNumberGuestsPromised(?int $number_guests_promised): static
    {
        $this->number_guests_promised = $number_guests_promised;

        return $this;
    }

    public function getDateInvited(): ?\DateTimeInterface
    {
        return $this->date_invited;
    }

    public function setDateInvited(?\DateTimeInterface $date_invited): static
    {
        $this->date_invited = $date_invited;

        return $this;
    }

    public function getDatePromised(): ?\DateTimeInterface
    {
        return $this->date_promised;
    }

    public function setDatePromised(?\DateTimeInterface $date_promised): static
    {
        $this->date_promised = $date_promised;

        return $this;
    }

    public function getDateMustPromise(): ?\DateTimeInterface
    {
        return $this->date_must_promise;
    }

    public function setDateMustPromise(?\DateTimeInterface $date_must_promise): static
    {
        $this->date_must_promise = $date_must_promise;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIsFamily(): ?bool
    {
        return $this->is_family;
    }

    public function setIsFamily(bool $is_family): static
    {
        $this->is_family = $is_family;

        return $this;
    }

    public function getSalutation(): ?GuestTypeEnum
    {
        return $this->salutation;
    }

    public function setSalutation(GuestTypeEnum $salutation): static
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getGuestComment(): ?string
    {
        return $this->guest_comment;
    }

    public function setGuestComment(?string $guest_comment): static
    {
        $this->guest_comment = $guest_comment;

        return $this;
    }

    public function isPromised(): ?bool
    {
        return $this->promised;
    }

    public function setPromised(?bool $promised): static
    {
        $this->promised = $promised;

        return $this;
    }

    public function getPromisedDate(): ?\DateTimeInterface
    {
        return $this->promised_date;
    }

    public function setPromisedDate(?\DateTimeInterface $promised_date): static
    {
        $this->promised_date = $promised_date;

        return $this;
    }
}
