<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn;

use AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\AbstractVirtualColumn;

/**
 * Class DQL
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation\VirtualColumn
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class DQL extends AbstractVirtualColumn
{
    /**
     * @var string
     */
    public $dql;
}