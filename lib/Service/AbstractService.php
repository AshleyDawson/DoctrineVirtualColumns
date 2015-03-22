<?php

namespace AshleyDawson\DoctrineVirtualColumns\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ServiceInterface
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Service
 */
abstract class AbstractService implements ServiceInterface
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