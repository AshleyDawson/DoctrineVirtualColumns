<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

use AshleyDawson\DoctrineVirtualColumns\EventListener\VirtualColumnEventListener;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventManager;

/**
 * Class EntityManagerSingleton
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests
 */
class EntityManagerSingleton
{
    use EntityManagerTrait;

    private static $instance;

    protected function getUsedEntityFixtures()
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

    protected function getEventManager()
    {
        $eventManager = new EventManager();

        $virtualColumnEventListener = new VirtualColumnEventListener(new AnnotationReader());

        $eventManager->addEventSubscriber($virtualColumnEventListener);

        return $eventManager;
    }

    public static function getInstance()
    {
        if ( ! self::$instance) {
            self::$instance = new self();
        }

        return self::$instance->getEntityManager();
    }
}