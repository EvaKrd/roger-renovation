<?php

namespace App\Entity;

use App\Repository\PicturesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PicturesRepository::class)]
class Pictures
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private $Filename;

    public function getFilename(): ?string
    {
        return $this->Filename;
    }

    public function setFilename(string $Filename): self
    {
        $this->Filename = $Filename;

        return $this;
    }
    public function __toString(): string
    {
        return $this->Filename;
    }

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?PictureDescription $description = null;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: Images::class)]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDescription(): ?PictureDescription
    {
        return $this->description;
    }

    public function setDescription(?PictureDescription $description): self
    {
        $this->description = $description;

        return $this;
    }

    // /**
    //  * @return Collection<int, Images>
    //  */
    // public function getImages(): Collection
    // {
    //     return $this->images;
    // }

    // public function addImage(Images $image): self
    // {
    //     if (!$this->images->contains($image)) {
    //         $this->images->add($image);
    //         $image->setRelation($this);
    //     }

    //     return $this;
    // }

    // public function removeImage(Images $image): self
    // {
    //     if ($this->images->removeElement($image)) {
    //         // set the owning side to null (unless already changed)
    //         if ($image->getRelation() === $this) {
    //             $image->setRelation(null);
    //         }
    //     }

    //     return $this;
    // }
}
