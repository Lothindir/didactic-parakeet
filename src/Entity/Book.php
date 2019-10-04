<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $Title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ExtractLink;

    /**
     * @ORM\Column(type="text")
     */
    private $Summary;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $AuthorLastName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $AuthorFirstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $Editor;

    /**
     * @ORM\Column(type="date")
     */
    private $ReleaseDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CoverImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Review", mappedBy="Book", orphanRemoval=true)
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getExtractLink(): ?string
    {
        return $this->ExtractLink;
    }

    public function setExtractLink(string $ExtractLink): self
    {
        $this->ExtractLink = $ExtractLink;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->Summary;
    }

    public function setSummary(string $Summary): self
    {
        $this->Summary = $Summary;

        return $this;
    }

    public function getAuthorLastName(): ?string
    {
        return $this->AuthorLastName;
    }

    public function setAuthorLastName(string $AuthorLastName): self
    {
        $this->AuthorLastName = $AuthorLastName;

        return $this;
    }

    public function getAuthorFirstName(): ?string
    {
        return $this->AuthorFirstName;
    }

    public function setAuthorFirstName(string $AuthorFirstName): self
    {
        $this->AuthorFirstName = $AuthorFirstName;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->Editor;
    }

    public function setEditor(string $Editor): self
    {
        $this->Editor = $Editor;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->ReleaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $ReleaseDate): self
    {
        $this->ReleaseDate = $ReleaseDate;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->CoverImage;
    }

    public function setCoverImage(string $CoverImage): self
    {
        $this->CoverImage = $CoverImage;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setBook($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->contains($review)) {
            $this->reviews->removeElement($review);
            // set the owning side to null (unless already changed)
            if ($review->getBook() === $this) {
                $review->setBook(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }
}
