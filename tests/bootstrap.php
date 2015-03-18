<?php

define('TESTS_TEMP_DIR', '/tmp');
define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));

$loader = require __DIR__.'/../vendor/autoload.php';

$loader->addPsr4('AshleyDawson\\DoctrineVirtualColumns\\Tests\\', __DIR__);

Doctrine\Common\Annotations\AnnotationRegistry::registerFile(
    VENDOR_PATH . '/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php'
);

$reader = new \Doctrine\Common\Annotations\AnnotationReader();
$reader = new \Doctrine\Common\Annotations\CachedReader($reader, new \Doctrine\Common\Cache\ArrayCache());

$_ENV['annotation_reader'] = $reader;