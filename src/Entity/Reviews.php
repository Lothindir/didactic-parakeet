<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReviewsRepository")
 */
class Reviews
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bookId;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reviews")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UserId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Rating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $RatingId;

    public function getBookId(): ?Book
    {
        return $this->bookId;
    }

    public function getUserId(): ?User
    {
        return $this->UserId;
    }

    public function getRatingId(): ?Rating
    {
        return $this->RatingId;
    }

    public function setRatingId(?Rating $RatingId): self
    {
        $this->RatingId = $RatingId;

        return $this;
    }
}
