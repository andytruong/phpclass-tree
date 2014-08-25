<?php

use Composer\Autoload\ClassLoader;
use Symfony\Component\ClassLoader\Psr4ClassLoader;
use Symfony\Component\ClassLoader\UniversalClassLoader;

$autoload_file[] = __DIR__ . '/../../autoload.php';
$autoload_file[] = __DIR__ . '/vendor/autoload.php';
$autoload_file[] = __DIR__ . '/../vendor/autoload.php';

foreach ($autoload_file as $file) {
    if (is_file($file)) {
        /* @var $composer_loader ClassLoader */
        $composer_loader = require $file;
        $composer_loader->addPsr4('AndyTruong\\PHPClassTree\\', __DIR__ . '/src');
        break;
    }
}

$config = require_once __DIR__ . '/config/config.php';
foreach ($config['autoload'] as $load_type => $mapping) {
    foreach ($mapping as $namespace => $paths) {
        switch ($load_type) {
            case 'psr-0':
                $composer_loader->add($namespace, $paths);
                break;
            case 'psr-4':
                $composer_loader->addPsr4($namespace, $paths);
                break;
        }
    }
}

return $composer_loader;
