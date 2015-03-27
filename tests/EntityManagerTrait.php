<?php

namespace AshleyDawson\DoctrineVirtualColumns\Tests;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Repository\DefaultRepositoryFactory;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\EventManager;
use Doctrine\ORM\Mapping\DefaultQuoteStrategy;

/**
 * Class EntityManagerTrait
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Tests
 */
trait EntityManagerTrait
{
    private $em;

    abstract protected function getUsedEntityFixtures();

    /**
     * EntityManager mock object together with
     * annotation mapping driver and pdo_sqlite
     * database in memory
     *
     * @param  EventManager $evm
     * @param \Doctrine\ORM\Configuration $config
     * @param array $conn
     * @return EntityManager
     */
    protected function getEntityManager(EventManager $evm = null, Configuration $config = null, array $conn = [])
    {
        if (null !== $this->em) {
            return $this->em;
        }

        $conn = array_merge(array(
            'driver' => 'pdo_sqlite',
            'memory' => false,
            'path' => TESTS_TEMP_DIR . '/db.sqlite',
        ), $conn);

        $config = is_null($config) ? $this->getAnnotatedConfig() : $config;

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = EntityManager::create($conn, $config, $evm ?: $this->getEventManager());

        $schema = array_map(function ($class) use ($em) {
            return $em->getClassMetadata($class);
        }, (array) $this->getUsedEntityFixtures());

        $schemaTool = new SchemaTool($em);
        $schemaTool->dropSchema($schema);
        $schemaTool->createSchema($schema);

        // Load fixtures
        $stmnt = $em->getConnection()->exec(file_get_contents(__DIR__ . '/Resource/fixture/data-fixtures.sql'));

        return $this->em = $em;
    }

    /**
     * Get annotation mapping configuration
     *
     * @return \Doctrine\ORM\Configuration
     */
    protected function getAnnotatedConfig()
    {
        // We need to mock every method except the ones which
        // handle the filters
        $configurationClass = 'Doctrine\ORM\Configuration';
        $refl = new \ReflectionClass($configurationClass);

        $methods = $refl->getMethods();
        $mockMethods = array();

        foreach ($methods as $method) {
            if (!in_array($method->name, ['addFilter', 'getFilterClassName', 'addCustomNumericFunction', 'getCustomNumericFunction'])) {
                $mockMethods[] = $method->name;
            }
        }

        $config = new \Doctrine\ORM\Configuration();

        $config->setProxyDir(TESTS_TEMP_DIR . '/proxy');
        $config->setProxyNamespace('Proxy');
        $config->setAutoGenerateProxyClasses(true);
        $config->setClassMetadataFactoryName('Doctrine\\ORM\\Mapping\\ClassMetadataFactory');
        $config->setMetadataDriverImpl($this->getMetadataDriverImplementation());
        $config->setDefaultRepositoryClassName('Doctrine\\ORM\\EntityRepository');
        $config->setQuoteStrategy(new DefaultQuoteStrategy());
        $config->setRepositoryFactory(new DefaultRepositoryFactory());

        $config->setResultCacheImpl(new ArrayCache(TESTS_TEMP_DIR));

        return $config;
    }

    /**
     * Creates default mapping driver
     *
     * @return \Doctrine\ORM\Mapping\Driver\Driver
     */
    protected function getMetadataDriverImplementation()
    {
        return new AnnotationDriver($_ENV['annotation_reader']);
    }

    /**
     * Build event manager
     *
     * @return EventManager
     */
    protected function getEventManager()
    {
        return new EventManager;
    }
}