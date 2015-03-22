<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation;

/**
 * Class Review
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture
 *
 * @ORM\Entity
 */
class Review
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
     * @var float
     *
     * @ORM\Column(name="rating", type="float")
     */
    private $rating;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="reviews")
     * @CacheInvalidation\AssociationNotifyOnChange(properties={"averageRating", "reviewCount", "bayesianAverage"})
     */
    private $post;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="review", cascade={"persist"})
     */
    private $votes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new ArrayCollection();
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
     * Get rating
     *
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set rating
     *
     * @param float $rating
     * @return Review
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
        return $this;
    }

    /**
     * Get post
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set post
     *
     * @param Post $post
     * @return Review
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * Add vote
     *
     * @param Vote $vote
     * @return $this
     */
    public function addVote(Vote $vote)
    {
        $this->votes->add($vote);
        return $this;
    }

    /**
     * Remove vote
     *
     * @param Vote $vote
     * @return $this
     */
    public function removeVote(Vote $vote)
    {
        $this->votes->remove($vote);
        return $this;
    }

    /**
     * Get votes
     *
     * @return Vote[]
     */
    public function getVote()
    {
        return $this->votes;
    }
}