<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation;

/**
 * Class SQL
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation
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

    /**
     * @var string
     */
    public $type = 'string';

}