<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Post
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture
 *
 * @ORM\Entity
 */
class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Review", mappedBy="post", cascade={"persist"})
     */
    private $reviews;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add review
     *
     * @param Review $review
     * @return $this
     */
    public function addReview(Review $review)
    {
        $this->reviews->add($review);
        return $this;
    }

    /**
     * Remove review
     *
     * @param Review $review
     * @return $this
     */
    public function removeReview(Review $review)
    {
        $this->reviews->remove($review);
        return $this;
    }

    /**
     * Get reviews
     *
     * @return Review[]
     */
    public function getReviews()
    {
        return $this->reviews;
    }
}