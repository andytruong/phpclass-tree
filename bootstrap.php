<?php


use Symfony\Component\ClassLoader\UniversalClassLoader;

$composer_loader = require_once __DIR__ . '/../../autoload.php';
$config = require_once __DIR__ . '/config/config.php';

$composer_loader->addPsr4('AndyTruong\\PHPClassTree\\', __DIR__ . '/src');

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