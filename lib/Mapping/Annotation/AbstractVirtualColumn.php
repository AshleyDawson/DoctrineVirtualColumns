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
     * @var string
     */
    public $type = 'string';

    /**
     * @var bool
     */
    public $isResultCached = false;
}