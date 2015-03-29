<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Service;

use AshleyDawson\DoctrineVirtualColumns\ColumnValueProvider\AbstractColumnValueProvider;

/**
 * Class BayesianAverage
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Service
 */
class BayesianAverage extends AbstractColumnValueProvider
{
    /**
     * {@inheritdoc}
     */
    public function getVirtualColumnValue()
    {
        // Sum of the votes

        $query = $this
            ->entityManager
            ->createQuery('SELECT SUM(v.value) FROM AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote v JOIN AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review r WHERE r.post = :post')
            ->setParameter('post', $this->entity)
        ;

        $sumOfVotes = (int) $query->getSingleScalarResult();

        // Average rating for this entity

        $query = $this
            ->entityManager
            ->createQuery('SELECT AVG(r.rating) FROM AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review r WHERE r.post = :post')
            ->setParameter('post', $this->entity)
        ;

        $averageRatingForThisEntity = (double) $query->getSingleScalarResult();

        // Top list threshold

        $topListThreshold = 3;

        // Average overall vote

        $query = $this
            ->entityManager
            ->createQuery('SELECT AVG(v.value) FROM AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote v')
        ;

        // fixme: should probably use result cache here for production
        //$query->useResultCache(true, 500);

        $overallAverageVote = (int) $query->getSingleScalarResult();

        // Calculate Bayesian average (rank)

        $bayesianAverage =
            ($sumOfVotes / ($sumOfVotes + $topListThreshold)) * $averageRatingForThisEntity +
            ($topListThreshold / ($sumOfVotes + $topListThreshold)) * $overallAverageVote
        ;

        return (double) $bayesianAverage;
    }
}
