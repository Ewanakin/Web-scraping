<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 500)]
    private $link;

    #[ORM\ManyToOne(targetEntity: Link::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private $fk_link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getFkLink(): ?Link
    {
        return $this->fk_link;
    }

    public function setFkLink(?Link $fk_link): self
    {
        $this->fk_link = $fk_link;

        return $this;
    }

    public function __toString()
    {
        return $this->link;
    }
}
