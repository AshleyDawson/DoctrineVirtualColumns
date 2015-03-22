<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation;

/**
 * Class DQLNotifyOnChange
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\CacheInvalidation
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class DQLNotifyOnChange
{
    /**
     * @var string
     */
    public $dql;

    /**
     * @var array | null
     */
    public $properties;
}
