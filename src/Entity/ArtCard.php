<?php

namespace App\Entity;

use App\Repository\ArtCardRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Table(name: '`ArtCard`')]
#[ORM\Entity(repositoryClass: ArtCardRepository::class)]
class ArtCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255)]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le champ ne peut être vide.")]
    private ?string $city;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $create_at;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'artCards')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    public function __construct()
    {
        $this->create_at = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeInterface $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
