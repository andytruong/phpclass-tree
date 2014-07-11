<?php

use Symfony\Component\ClassLoader\UniversalClassLoader;

$autoload_file[] = __DIR__ . '/../../autoload.php';
$autoload_file[] = __DIR__ . '/vendor/autoload.php';

foreach ($autoload_file as $file) {
    if (is_file($file)) {
        $composer_loader = require $file;
        $composer_loader->addPsr4('AndyTruong\\PHPClassTree\\', __DIR__ . '/src');
        break;
    }
}

$config = require_once __DIR__ . '/config/config.php';
$loader = new UniversalClassLoader();
foreach ($config['autoload'] as $load_type => $mapping) {
    foreach ($mapping as $namespace => $paths) {
        switch ($load_type) {
            case 'psr-0':
                $loader->registerNamespace($namespace, $paths);
                break;
        }
    }
}
$loader->register();

return $loader;
