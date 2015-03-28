<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

use AshleyDawson\DoctrineVirtualColumns\EventListener\VirtualColumnEventListener;
use AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review;

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

        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(5));
        $materiaPost->addReview((new Review())->setPost($materiaPost)->setRating(4.5));

        $this->getEntityManager()->persist($materiaPost);

        $this->getEntityManager()->flush();

        echo "------------\n";

        echo 'Average Rating: ' . $materiaPost->getAverageRating() . "\n";
        echo 'Review Count: ' . $materiaPost->getReviewCount() . "\n";
        echo 'Bayesian Average: ' . $materiaPost->getBayesianAverage() . "\n";

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