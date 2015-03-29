<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

use AshleyDawson\DoctrineVirtualColumns\EventListener\VirtualColumnEventListener;
use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review;
use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote;

/**
 * Class DoctrineVirtualColumnsTest
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests
 */
class DoctrineVirtualColumnsTest extends AbstractDoctrineTestCase
{
    protected function setUp()
    {
        $this
            ->getEntityManager()
            ->getConnection()
            ->exec(file_get_contents(__DIR__ . '/Resource/fixture/data-fixtures.sql'))
        ;
    }

    public function testCrudOperations()
    {
        /** @var \AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaPost $materiaPost */
        $materiaPost = $this->getEntityManager()->getRepository('AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaPost')->find(4);

        echo 'Average Rating: ' . $materiaPost->getAverageRating() . "\n";
        echo 'Review Count: ' . $materiaPost->getReviewCount() . "\n";
        echo 'Bayesian Average: ' . $materiaPost->getBayesianAverage() . "\n";
        echo 'Vote Count: ' . $materiaPost->getVoteCount() . "\n";

        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(5));
        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(4.5));
        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(4));

        $this->getEntityManager()->persist($materiaPost);

        $this->getEntityManager()->flush();

        echo "------------\n";

        echo 'Average Rating: ' . $materiaPost->getAverageRating() . "\n";
        echo 'Review Count: ' . $materiaPost->getReviewCount() . "\n";
        echo 'Bayesian Average: ' . $materiaPost->getBayesianAverage() . "\n";
        echo 'Vote Count: ' . $materiaPost->getVoteCount() . "\n";

        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(5));

        $review = new Review();

        $review->setPost($materiaPost)->setRating(4)->addVote((new Vote())->setValue(1)->setReview($review))->addVote((new Vote())->setValue(1)->setReview($review));

        $materiaPost->addReview($review);
        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(2));

        $this->getEntityManager()->persist($materiaPost);

        $this->getEntityManager()->flush();

        echo "------------\n";

        echo 'Average Rating: ' . $materiaPost->getAverageRating() . "\n";
        echo 'Review Count: ' . $materiaPost->getReviewCount() . "\n";
        echo 'Bayesian Average: ' . $materiaPost->getBayesianAverage() . "\n";
        echo 'Vote Count: ' . $materiaPost->getVoteCount() . "\n";

        $vote = $this->getEntityManager()->getRepository('AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote')->find(54);

        $vote->setValue(-1);

        $this->getEntityManager()->persist($vote);

        $this->getEntityManager()->flush();

        $review = $this->getEntityManager()->getRepository('AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review')->find(26);

        $this->getEntityManager()->remove($review);

        $this->getEntityManager()->flush();

        echo "------------\n";

        echo 'Average Rating: ' . $materiaPost->getAverageRating() . "\n";
        echo 'Review Count: ' . $materiaPost->getReviewCount() . "\n";
        echo 'Bayesian Average: ' . $materiaPost->getBayesianAverage() . "\n";
        echo 'Vote Count: ' . $materiaPost->getVoteCount() . "\n";
    }

    /**
     * {@inheritdoc}
     */
    protected function getEntityClassNames()
    {
        return [
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\AbstractPost',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\ProductPost',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaPost',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaType',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\User',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Department',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Enemy',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getEventManager()
    {
        $evm = parent::getEventManager();
        $evm->addEventSubscriber(new VirtualColumnEventListener($_ENV['annotation_reader']));
        return $evm;
    }
}