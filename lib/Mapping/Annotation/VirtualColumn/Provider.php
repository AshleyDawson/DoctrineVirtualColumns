<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\AbstractVirtualColumn;

/**
 * Class Provider
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn
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