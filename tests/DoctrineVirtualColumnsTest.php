<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

/**
 * Class DoctrineVirtualColumnsTest
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests
 */
class DoctrineVirtualColumnsTest extends \PHPUnit_Framework_TestCase
{
    public function testCrudOperations()
    {
        $em = EntityManagerSingleton::getInstance();

        /** @var \AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaPost $materiaPost */
        $materiaPost = $em->getRepository('AshleyDawson\DoctrineVirtualColumns\Tests\Fixture\MateriaPost')->find(4);

//        echo get_class($materiaPost) . "\n";
//        echo $materiaPost->getName() . "\n";
    }
}