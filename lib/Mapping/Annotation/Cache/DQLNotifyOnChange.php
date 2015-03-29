<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\Cache;

/**
 * Class DQLNotifyOnChange
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\Cache
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
