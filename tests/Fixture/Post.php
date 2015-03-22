<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

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
     * @var float
     *
     * @VirtualColumn\DQL(
     *     dql="SELECT AVG(r.rating) FROM AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review r WHERE r.post = :this",
     *     type="float",
     *     isResultCached=true
     * )
     */
    private $averageRating;

    /**
     * @var float
     *
     * @VirtualColumn\SQL(
     *     sql="SELECT COUNT(*) FROM Review r WHERE r.post_id = :this.id",
     *     type="integer",
     *     isResultCached=true
     * )
     */
    private $reviewCount;

    /**
     * @var float
     *
     * @VirtualColumn\Service(
     *     service="AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Service\BayesianAverage",
     *     type="float",
     *     isResultCached=true
     * )
     */
    private $bayesianAverage;

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

    /**
     * Get averageRating
     *
     * @return float
     */
    public function getAverageRating()
    {
        return $this->averageRating;
    }

    /**
     * Get reviewCount
     *
     * @return float
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * Get bayesianAverage
     *
     * @return float
     */
    public function getBayesianAverage()
    {
        return $this->bayesianAverage;
    }
}