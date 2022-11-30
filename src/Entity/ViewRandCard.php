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

    public function getId(): ?int
    {
        return $this->id;
    }
}
