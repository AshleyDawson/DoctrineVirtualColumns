<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Post;
use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review;
use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote;

/**
 * Class DoctrineVirtualColumnsTest
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests
 */
class DoctrineVirtualColumnsTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $em = EntityManagerSingleton::getInstance();

        $post = new Post();

        $post
            ->addReview((new Review())->setPost($post)->setRating(1))
            ->addReview((new Review())->setPost($post)->setRating(1.5))
            ->addReview((new Review())->setPost($post)->setRating(5))
            ->addReview((new Review())->setPost($post)->setRating(4))
            ->addReview((new Review())->setPost($post)->setRating(5))
            ->addReview((new Review())->setPost($post)->setRating(5))
            ->addReview((new Review())->setPost($post)->setRating(2.5))
            ->addReview((new Review())->setPost($post)->setRating(5))
            ->addReview((new Review())->setPost($post)->setRating(1))
            ->addReview((new Review())->setPost($post)->setRating(1.5))
        ;

        foreach ($post->getReviews() as $review) {
            for ($i = 0; $i < mt_rand(0, 10); $i ++) {
                $review->addVote((new Vote())->setReview($review)->setValue(mt_rand(1, 2) % 2 ? 1 : -1));
            }
        }

        $em->persist($post);

        $em->flush();
    }

    public function testCrudOperations()
    {
        $em = EntityManagerSingleton::getInstance();

        $post = $em->getRepository('AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Post')->find(1);

        $post->addReview((new Review())->setPost($post)->setRating(2.5));

        $em->persist($post);

        $em->flush();

        echo $post->getId() . " :\n";

        var_dump($post->getAverageRating());

        var_dump($post->getReviewCount());

        var_dump($post->getBayesianAverage());

        foreach ($post->getReviews() as $review) {

            echo "  " . $review->getId() . " - " . $review->getRating() . "\n";
        }
    }
}