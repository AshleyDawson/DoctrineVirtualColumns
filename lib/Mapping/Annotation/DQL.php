<?php

namespace AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation;

/**
 * Class DQL
 *
 * @package AshleyDawson\DoctrineVirtualColumns\Mapping\Annotation
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

    /**
     * @var string
     */
    public $type = 'string';

}