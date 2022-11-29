<?php

namespace App\Entity;

use App\Repository\ViewRandCardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: '`View_Rand_Card`')]
#[ORM\Entity(repositoryClass: ViewRandCardRepository::class, readOnly: true)]
class ViewRandCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column(length: 255)]
    private ?string $pictureArt;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description;

    #[ORM\Column(type: 'string')]
    private ?string $city;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $create_at;

    #[ORM\Column(type: 'boolean')]
    private ?bool $pending;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'artCards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getPictureArt(): ?string
    {
        return $this->pictureArt;
    }

    public function getPending(): ?bool
    {
        return $this->pending;
    }
}
