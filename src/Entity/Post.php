<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=2, minMessage="Málo písmenek!!!!")
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="posts")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Label::class, mappedBy="post", cascade={"persist", "remove"})
     */
    private $labels;

    /**
     * @ORM\OneToOne(targetEntity=PostImage::class, cascade={"persist", "remove"}, inversedBy="post")
     */
    private $image;

    public function __construct()
    {
        $this->labels = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Label[]
     */
    public function getLabels(): Collection
    {
        return $this->labels;
    }

    public function addLabel(Label $label): self
    {
        if (!$this->labels->contains($label)) {
            $this->labels[] = $label;
            $label->setPost($this);
        }

        return $this;
    }

    public function removeLabel(Label $label): self
    {
        if ($this->labels->removeElement($label)) {
            // set the owning side to null (unless already changed)
            if ($label->getPost() === $this) {
                $label->setPost(null);
            }
        }

        return $this;
    }

    public function getImage(): ?PostImage
    {
        return $this->image;
    }

    public function setImage(?PostImage $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }


}
