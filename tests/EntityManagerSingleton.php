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
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Post',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Review',
            'AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\Vote',
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