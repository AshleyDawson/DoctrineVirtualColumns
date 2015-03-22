<?php

namespace AshleyDawson\DoctrineVirtualColumns\Service;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Interface ServiceInterface
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Service
 */
interface ServiceInterface
{
    /**
     * Inject entity manager
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager);

    /**
     * Set the subject entity
     *
     * @param object $entity
     */
    public function setEntity($entity);

    /**
     * Get the resultant PHP value from this service to be inserted
     * into the virtual column
     *
     * @return mixed
     */
    public function getResultantValue();
}