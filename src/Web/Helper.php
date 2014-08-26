<?php

namespace AndyTruong\PHPClassTree\Web;

use AndyTruong\PHPClassTree\PHPClassTreeReader;
use Symfony\Component\ClassLoader\ClassLoader;

class Helper
{

    /** @var ClassLoader */
    protected $loader;

    /** @var PHPClassTreeReader */
    protected $reader;

    public function __construct($loader, $reader)
    {
        $this->loader = $loader;
        $this->reader = $reader;
    }

    function urlNamespace($namespace, $name)
    {
        return '<a href="./index.php?namespace=' . $namespace . '">' . $name . '</a>';
    }

    function urlClass($class, $name)
    {
        return '<a href="./index.php?class=' . $class . '">' . $name . '</a>';
    }

    function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
            $files = array_merge($files, $this->rglob($dir . '/' . basename($pattern), $flags));
        }
        return $files;
    }

}
