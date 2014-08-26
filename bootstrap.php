<?php

use Composer\Autoload\ClassLoader;

$autoload_file[] = __DIR__ . '/../../autoload.php';
$autoload_file[] = __DIR__ . '/vendor/autoload.php';
$autoload_file[] = __DIR__ . '/../vendor/autoload.php';

/* @var $loader ClassLoader */
foreach ($autoload_file as $file) {
    if (is_file($file)) {
        $loader = require $file;
        $loader->addPsr4('AndyTruong\\PHPClassTree\\', __DIR__ . '/src');
        break;
    }
}

$config = require_once __DIR__ . '/config/config.php';
foreach ($config['autoload'] as $load_type => $mapping) {
    foreach ($mapping as $namespace => $paths) {
        switch ($load_type) {
            case 'psr-0':
                $loader->add($namespace, $paths);
                break;
            case 'psr-4':
                $loader->addPsr4($namespace, $paths);
                break;
        }
    }
}

return $loader;
