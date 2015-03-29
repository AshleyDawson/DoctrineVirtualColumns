<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation;

/**
 * Class Provider
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Provider extends AbstractVirtualColumn
{
    /**
     * @var string | object
     */
    public $provider;
}