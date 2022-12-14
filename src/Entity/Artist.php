<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArtistRepository;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
class Artist extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'string')]
    private ?string $urlProfilPicture;

    public function getId(): ?int
    {
        return $this->id = parent::getId();
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrlProfilPicture(): ?string
    {
        return $this->urlProfilPicture;
    }

    public function setUrlProfilPicture(?string $urlProfilPicture): self
    {
        $this->urlProfilPicture = $urlProfilPicture;

        return $this;
    }
}
