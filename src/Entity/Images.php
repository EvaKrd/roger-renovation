<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pictures $relation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRelation(): ?Pictures
    {
        return $this->relation;
    }

    public function setRelation(?Pictures $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
