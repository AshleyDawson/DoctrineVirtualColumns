<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $post;

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
}