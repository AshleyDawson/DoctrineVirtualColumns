<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation;

/**
 * Class AssociationNotifyOnChange
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class AssociationNotifyOnChange
{
    /**
     * @var array | null
     */
    public $properties;
}
