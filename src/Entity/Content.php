<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 1000)]
    private $content;

    #[ORM\ManyToOne(targetEntity: Link::class, inversedBy: 'contents')]
    #[ORM\JoinColumn(nullable: false)]
    private $fk_id_link;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getFkIdLink(): ?Link
    {
        return $this->fk_id_link;
    }

    public function setFkIdLink(?Link $fk_id_link): self
    {
        $this->fk_id_link = $fk_id_link;

        return $this;
    }

    public function __toString()
    {
        return $this->content;
    }
}
