<?php

namespace App\Entity;

use App\Repository\ArtCardRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;


#[ORM\Table(name: 'ArtCard')]
#[ORM\Entity(repositoryClass: ArtCardRepository::class)]
class ArtCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $title;

    #[ORM\Column(nullable: false)]
    private ?string $pictureArt;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string', nullable: false)]
    #[Assert\NotBlank(message: "Le champ ne peut être vide.")]
    private ?string $city;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $create_at;

    #[ORM\Column(type: 'boolean')]
    private ?bool $pending;

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

    public function getFileNameArt(): ?string
    {
        return $this->pictureArt;
    }

    public function getPictureArt(): ?string
    {
        return '/' . $_ENV['ARTPICTURE_FOLDER'] . $this->pictureArt;
    }

    public function setPictureArt(string $pictureArt): self
    {
        $this->pictureArt = $pictureArt;

        return $this;
    }

    public function getPending(): ?bool
    {
        return $this->pending;
    }

    public function setPending(bool $pending): self
    {
        $this->pending = $pending;

        return $this;
    }
}
