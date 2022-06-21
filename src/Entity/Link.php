<?php

namespace App\Entity;

use App\Repository\LinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkRepository::class)]
class Link
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $link;

    #[ORM\ManyToOne(targetEntity: Search::class, inversedBy: 'links')]
    #[ORM\JoinColumn(nullable: false)]
    private $fk_id_search;

    #[ORM\OneToMany(mappedBy: 'fk_id_link', targetEntity: Content::class)]
    private $contents;

    #[ORM\OneToMany(mappedBy: 'fk_link', targetEntity: Image::class)]
    private $images;

    public function __construct()
    {
        $this->contents = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

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

    public function getFkIdSearch(): ?Search
    {
        return $this->fk_id_search;
    }

    public function setFkIdSearch(?Search $fk_id_search): self
    {
        $this->fk_id_search = $fk_id_search;

        return $this;
    }

    
    public function __toString()
    {
        return $this->link;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
            $content->setFkIdLink($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->contents->removeElement($content)) {
            // set the owning side to null (unless already changed)
            if ($content->getFkIdLink() === $this) {
                $content->setFkIdLink(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFkLink($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getFkLink() === $this) {
                $image->setFkLink(null);
            }
        }

        return $this;
    }
}
