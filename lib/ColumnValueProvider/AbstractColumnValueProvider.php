<?php

namespace AshleyDawson\DoctrineVirtualColumns\ColumnValueProvider;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AbstractColumnValueProvider
 *
 * @package AshleyDawson\DoctrineVirtualColumns\ColumnValueProvider
 */
abstract class AbstractColumnValueProvider implements ColumnValueProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var object
     */
    protected $entity;

    /**
     * {@inheritdoc}
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }
}