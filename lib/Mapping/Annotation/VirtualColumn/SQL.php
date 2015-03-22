<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\AbstractVirtualColumn;

/**
 * Class SQL
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class SQL extends AbstractVirtualColumn
{
    /**
     * @var string
     */
    public $sql;
}