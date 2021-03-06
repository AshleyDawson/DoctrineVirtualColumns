<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation;

/**
 * Class AbstractVirtualColumn
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation
 */
abstract class AbstractVirtualColumn
{
    /**
     * @var bool
     */
    public $isResultCached = false;

    /**
     * @var int
     */
    public $cacheLifeTime = 0;
}