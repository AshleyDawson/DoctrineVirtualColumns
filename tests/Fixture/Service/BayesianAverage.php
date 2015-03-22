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
        $query = $this
            ->entityManager
            ->createQuery('SELECT AVG(v.value) FROM AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote v JOIN AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review r WHERE r.post = :post')
            ->setParameter('post', $this->entity)
        ;

        return $query->getSingleScalarResult();
    }
}