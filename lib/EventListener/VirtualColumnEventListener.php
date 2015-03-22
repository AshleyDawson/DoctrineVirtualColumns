<?php

namespace AshleyDawson\DoctrineVirtualColumns\EventListener;

use AshleyDawson\DoctrineVirtualColumns\ColumnValueProvider\ColumnValueProviderInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class VirtualColumnEventListener
 *
 * @package AshleyDawson\DoctrineVirtualColumns\EventListener
 */
class VirtualColumnEventListener implements EventSubscriber
{
    /**
     * @var AnnotationReader
     */
    protected $annotationReader;

    private static $changedEntities = [];

    /**
     * Constructor
     *
     * @param AnnotationReader $annotationReader
     */
    public function __construct(AnnotationReader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postLoad,
            Events::postFlush,
            Events::onFlush,
        ];
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();

        self::$changedEntities = array_merge(
            $entityManager->getUnitOfWork()->getScheduledEntityInsertions(),
            $entityManager->getUnitOfWork()->getScheduledEntityUpdates()
        );
    }

    public function postFlush(PostFlushEventArgs $args)
    {
        $entityManager = $args->getEntityManager();

        $resultCache = $entityManager->getConfiguration()->getResultCacheImpl();

        $accessor = PropertyAccess::createPropertyAccessor();

        foreach (self::$changedEntities as $entity) {

            $reflectionClass = new \ReflectionClass($entity);

            /** @var \AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation\DQLNotifyOnChange $dqlNotifyAnnotation */
            $dqlNotifyAnnotation = $this->annotationReader->getClassAnnotation($reflectionClass, 'AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation\DQLNotifyOnChange');

            if ($dqlNotifyAnnotation) {

                $parameters = [];

                preg_match('/.*(\:[a-z0-9\.\[\]_]+).*/i', $dqlNotifyAnnotation->dql, $matches);

                if (is_array($matches) && isset($matches[0])) {

                    unset($matches[0]);

                    $accessor = PropertyAccess::createPropertyAccessor();

                    foreach ($matches as $key => $expression) {

                        $paramName = sprintf(':exp_%d', $key);

                        $dqlNotifyAnnotation->dql = str_replace($expression, $paramName, $dqlNotifyAnnotation->dql);

                        $expression = str_replace(':this.', '', $expression);

                        $parameters[$paramName] = $accessor->getValue($entity, $expression);
                    }
                }

                $targetEntities = $entityManager->createQuery($dqlNotifyAnnotation->dql)->setParameters($parameters)->getResult();

                foreach ($targetEntities as $targetEntity) {

                    $entityIdentifiers = $entityManager->getUnitOfWork()->getEntityIdentifier($targetEntity);

                    foreach ($dqlNotifyAnnotation->properties as $targetProperty) {

                        $cacheKey = $this->buildCacheKey(get_class($targetEntity), $entityIdentifiers, $targetProperty);

                        if ($resultCache->contains($cacheKey)) {
                            echo "HIT DQL! - ", $cacheKey, " - ", get_class($targetEntity), " - ", implode(',', $entityIdentifiers), " - ", $targetProperty, "\n";
                            $resultCache->delete($cacheKey);
                        }
                    }
                }
            }









            $reflectionProperties = $reflectionClass->getProperties();

            foreach ($reflectionProperties as $reflectionProperty) {

                /** @var \AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation\AssociationNotifyOnChange $notifyOnChangeAnnotation */
                $notifyOnChangeAnnotation = $this->annotationReader->getPropertyAnnotation(
                    $reflectionProperty,
                    'AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation\AssociationNotifyOnChange'
                );

                if ($notifyOnChangeAnnotation) {

                    $targetEntity = $accessor->getValue($entity, $reflectionProperty->getName());

                    $entityIdentifiers = $entityManager->getUnitOfWork()->getEntityIdentifier($targetEntity);

                    foreach ($notifyOnChangeAnnotation->properties as $targetProperty) {

                        $cacheKey = $this->buildCacheKey(get_class($targetEntity), $entityIdentifiers, $targetProperty);

                        if ($resultCache->contains($cacheKey)) {
                            echo "HIT ASSOC! - ", $cacheKey, " - ", get_class($targetEntity), " - ", implode(',', $entityIdentifiers), " - ", $targetProperty, "\n";
                            $resultCache->delete($cacheKey);
                        }
                    }
                }
            }
        }


















        $uow = $entityManager->getUnitOfWork();

        $identityMap = $uow->getIdentityMap();

        foreach ($identityMap as $identities) {

            foreach ($identities as $entity) {

                if ($entityManager->contains($entity)) {

                    $this->processVirtualColumns($entityManager, $entity);
                }
            }
        }
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->processVirtualColumns($args->getEntityManager(), $args->getEntity());
    }

    private function processVirtualColumns(EntityManagerInterface $entityManager, $entity)
    {
        $resultCache = $entityManager->getConfiguration()->getResultCacheImpl();

        $reflectionProperties = (new \ReflectionObject($entity))->getProperties();

        /** @var \ReflectionProperty $reflectionProperty */
        foreach ($reflectionProperties as $reflectionProperty) {

            $entityIdentifiers = $entityManager->getUnitOfWork()->getEntityIdentifier($entity);

            $cacheKey = $this->buildCacheKey(get_class($entity), $entityIdentifiers, $reflectionProperty->getName());

            /** @var \AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\DQL $dqlAnnotation */
            $dqlAnnotation = $this->annotationReader->getPropertyAnnotation(
                $reflectionProperty,
                'AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\DQL'
            );

            if ($dqlAnnotation) {

                if ($dqlAnnotation->dql) {

                    if ($resultCache->contains($cacheKey)) {
                        $value = $resultCache->fetch($cacheKey);
                    }
                    else {

                        $value = $entityManager
                            ->createQuery($dqlAnnotation->dql)
                            ->setParameter('this', $entity)
                            ->getSingleScalarResult()
                        ;

                        $value = Type::getType($dqlAnnotation->type)
                            ->convertToPHPValue(
                                $value,
                                $entityManager->getConnection()->getDatabasePlatform()
                            )
                        ;

                        $resultCache->save($cacheKey, $value);
                    }

                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($entity, $value);
                }
            }

            /** @var \AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\SQL $sqlAnnotation */
            $sqlAnnotation = $this->annotationReader->getPropertyAnnotation(
                $reflectionProperty,
                'AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\SQL'
            );

            if ($sqlAnnotation) {

                if ($sqlAnnotation->sql) {

                    if ($resultCache->contains($cacheKey)) {
                        $value = $resultCache->fetch($cacheKey);
                    }
                    else {

                        $parameters = [];

                        preg_match('/.*(\:[a-z0-9\.\[\]_]+).*/i', $sqlAnnotation->sql, $matches);

                        if (is_array($matches) && isset($matches[0])) {

                            unset($matches[0]);

                            $accessor = PropertyAccess::createPropertyAccessor();

                            foreach ($matches as $key => $expression) {

                                $paramName = sprintf(':exp_%d', $key);

                                $sqlAnnotation->sql = str_replace($expression, $paramName, $sqlAnnotation->sql);

                                $expression = str_replace(':this.', '', $expression);

                                $parameters[$paramName] = $accessor->getValue($entity, $expression);
                            }
                        }

                        $statement = $entityManager->getConnection()->prepare($sqlAnnotation->sql);

                        $statement->execute($parameters);

                        if ($statement->rowCount() > 1) {
                            throw new \Exception('Must only return row');
                        }

                        $value = $statement->fetchColumn(0);

                        $value = Type::getType($sqlAnnotation->type)
                            ->convertToPHPValue(
                                $value,
                                $entityManager->getConnection()->getDatabasePlatform()
                            )
                        ;

                        $resultCache->save($cacheKey, $value);
                    }

                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($entity, $value);
                }
            }

            /** @var \AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\Provider $serviceAnnotation */
            $serviceAnnotation = $this->annotationReader->getPropertyAnnotation(
                $reflectionProperty,
                'AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn\Provider'
            );

            if ($serviceAnnotation) {

                if ($serviceAnnotation->provider) {

                    $value = null;

                    if ($resultCache->contains($cacheKey)) {
                        $value = $resultCache->fetch($cacheKey);
                    }
                    else {

                        $service = $serviceAnnotation->provider;

                        if (is_string($service) && class_exists($service)) {
                            $service = new $service();
                        }

                        if (is_object($service) && $service instanceof ColumnValueProviderInterface) {

                            $service->setEntityManager($entityManager);
                            $service->setEntity($entity);

                            $value = $service->getVirtualColumnValue();

                            // todo: don't think this transformation is necessary as a service can be directly specified
                            // todo: maybe it is a good idea to leave it on here to enforce type?
                            $value = Type::getType($serviceAnnotation->type)
                                ->convertToPHPValue(
                                    $value,
                                    $entityManager->getConnection()->getDatabasePlatform()
                                )
                            ;

                            $resultCache->save($cacheKey, $value);
                        }
                    }

                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($entity, $value);
                }
            }
        }
    }

    private function buildCacheKey($entityClass, array $entityPrimaryKeys, $propertyName)
    {
        return md5(serialize($entityPrimaryKeys) . $propertyName . $entityClass);
    }
}