<?php

define('TESTS_TEMP_DIR', __DIR__ . '/../tmp/doctrine-virtual-columns');
define('VENDOR_PATH', realpath(__DIR__ . '/../vendor'));

$loader = require __DIR__.'/../vendor/autoload.php';

$loader->addPsr4('AshleyDawson\\DoctrineVirtualColumns\\Tests\\', __DIR__);

\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$reader = new \Doctrine\Common\Annotations\AnnotationReader();
$reader = new \Doctrine\Common\Annotations\CachedReader($reader, new \Doctrine\Common\Cache\ArrayCache());

$_ENV['annotation_reader'] = $reader;