<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\AbstractVirtualColumn;

/**
 * Class Service
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Service extends AbstractVirtualColumn
{
    /**
     * @var string | object
     */
    public $service;
}